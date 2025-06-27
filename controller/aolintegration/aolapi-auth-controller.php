<?php 

include_once Mastercfg::$homedir.'entities/shipper/Shipper.php';
class Aolauthctr{
	private static $instance = null;
	private $landingpage = 'aol-integration/';
	private $registerpage = 'aol-integration/auth/register';
	private $reqaccesspage = 'aol-integration/auth/request-access/';
	private $callbackpage = 'aol-integration/auth/callback/';
	private $responseerr = 'aol-integration/auth/response-error';
	private $responsesuccess = 'aol-integration/auth/database-selection/';
	private $basicapiurl = 'https://account.accurate.id/api';
	private $dbopenurl = 'https://account.accurate.id/api/open-db.do';
	private $aolapiindexpage = 'aol-integration/aol-menus?r=';
	private $resdetpage = 'aol-integration/aol-io/res-details?b=';
	private $resworkdbselection = 'aol-integration/auth/resume-work-select-db/';

	public static function getInstanceOfAolauthctr(){
    	if (self::$instance==null) {
			self::$instance = new Aolauthctr();
		}
		return self::$instance;
    }
    private function __construct(){}

	public function TrialLimit() {
		$data = Shipper::getInstance(Mastercfg::getCfgInstance());
		$data->Model('aolmodel/Aolintegration');
		$aolmdl = AolIntegrationmdl::getAolIntegrationmdlInstance();

		$data->Lib('redis/myredis');
    	$newsession = json_decode(getRedisKey("token:".$_COOKIE['fac_token'], $data));
    	$logindata = array(['username'=>$newsession->username,'nama'=>$newsession->nama,'email'=>$newsession->email]);

		$data->Ent('Filebean');

		$data->judul = 'AOL Access - Trial Limit';
        $data->subtitle = 'Awh, Snap! - Trial Limitation Reached :(';
		$data->p1 = 'You have reached the limit of trial access for Accurate API. Please contact our administrator to get full access :)';
		$data->p2 = 'Hi, '.$logindata[0]['nama'].' we have some limitation for trial users, please contact administrator to keep using our product :)';
        $data->page = 'aolauth';

        $data->View('aolintegration/authorization/vtriallimit.aolauth',$data);
	}

    private function PostDatabase($reqid,$id,$dbname){
    	// header('Content-Type: application/json');
		// header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		// header("Cache-Control: post-check=0, pre-check=0", false);
		// header("Pragma: no-cache");
		$data = Shipper::getInstance(Mastercfg::getCfgInstance());
		$data->Model('aolmodel/Aolintegration');
    	$aolmdl = AolIntegrationmdl::getAolIntegrationmdlInstance();
		$data->Ent('Aoldbsessionbean');
		$data->Lib('functions/Fcurl');
		$data->Ent('Filebean');
		
		$data->Lib('redis/myredis');
    	$newsession = json_decode(getRedisKey("token:".$_COOKIE['fac_token'], $data));
    	$logindata = array(['username'=>$newsession->username,'nama'=>$newsession->nama,'email'=>$newsession->email]);

		$implicitresdet = $aolmdl->GetTokenImplicitAuth($reqid);
    	$responsestring = CurlGetWithParameter($this->dbopenurl,$implicitresdet[0]['saccesstoken'],["id"=>$id]);

		$res = json_encode($responsestring);
		$aolmdl->SaveAPIResponse('2',$implicitresdet[0]['id'],'-',$res);
		Filebean::AolWriteErrorLog($data,$logindata[0]['username'],'DB Request Response: '.$res);
		$resobj = json_decode($res);
		$resobjfinal = json_decode($resobj);
		// echo $resobjfinal->dataVersion;

		if ($resobjfinal->s) {
			$obj = new Aoldbsession();

			$obj->setId($id.$reqid.$resobjfinal->session);
			$obj->setVersion($resobjfinal->dataVersion);
			$obj->setLicenseend($resobjfinal->licenseEnd);
			$obj->setDbsession($resobjfinal->session);
			$obj->setDbhost($resobjfinal->host);
			$obj->setSessionexp($resobjfinal->accessibleUntil);
			$obj->setIsadmin($resobjfinal->admin);
			$obj->setIstrial($resobjfinal->trial);
			$obj->setReferrence($reqid);
			$r = $aolmdl->InsertDatabaseSession($obj->getId(),$obj->getVersion(),$obj->getLicenseend(),$obj->getDbsession(),$obj->getDbhost(),$id,$obj->getSessionexp(),$obj->getIsadmin(),$obj->getIstrial(),$obj->getReferrence(),$dbname,$logindata[0]['username']);
			return ['result'=>$r,'id'=>$obj->getId()];
		}else{
			return ['result'=>false,'id'=>'no id received'];
		}
			
    }

    public function DatabaseSelection($reqid){
    	$data = Shipper::getInstance(Mastercfg::getCfgInstance());
    	$data->Model('aolmodel/Aolintegration');
    	
    	$aolmdl = AolIntegrationmdl::getAolIntegrationmdlInstance();

    	$data->Lib('functions/Fcurl');

    	$data->Ent('Filebean');
    	$data->Lib('redis/myredis');
    	$newsession = json_decode(getRedisKey("token:".$_COOKIE['fac_token'], $data));
    	$logindata = array(['username'=>$newsession->username,'nama'=>$newsession->nama,'email'=>$newsession->email]);

    	$implicitresdet = $aolmdl->GetTokenImplicitAuth($reqid);

    	if (isset($_POST['req'])) {
    		if ($_SESSION['aolfrtoken'] == $_POST['req']['token']) {
    			$dbcallback = $this->PostDatabase($reqid,$_POST['req']['dbselected'],$_POST['req']['dbname']); 
    			if ($dbcallback['result']) {
    				$redirpage = $data->base_url.$this->aolapiindexpage.$dbcallback['id'];
    				Filebean::AolWriteDebugLog($data,$logindata[0]['username'],'Response of OpenDB has been successfully saved.');
    				Filebean::AolWriteDebugLog($data,$logindata[0]['username'],'Redirect page: '.$redirpage);
    				echo "<script>location.replace('".$redirpage."');</script>";
    				return;
    			}else{
    				echo "<script>alert('Cannot open database, please contact administrator');</script>";
    				echo "<script>location.replace('".$data->base_url.$this->responsesuccess.$reqid."');</script>";
    			}
    		}else{
    			Filebean::AolWriteErrorLog($data,$logindata[0]['username'],'Form token has been expired.');
    			echo "<script>alert('Your time to submit form has ended, please re-submit the form.');</script>";
    		}
    		
    	}
    	Filebean::AolWriteDebugLog($data,$logindata[0]['username'],'Accessing DB Selection Page.');
    	Filebean::AolWriteDebugLog($data,$logindata[0]['username'],'Request ID: '.$reqid);
    	$url = $this->basicapiurl.'/db-list.do';
    	Filebean::AolWriteDebugLog($data,$logindata[0]['username'],'URL DB List: '.$url);
    	$response = json_decode(CurlGetAOLAPI($url,$implicitresdet[0]['saccesstoken']));


    	$canselectdb = $aolmdl->CheckEntitlementByName('Request Database Access Token',$logindata[0]['username']);

    	if (count($canselectdb) < 1) {
    		header('Location:'.$data->base_url.$this->landingpage);
    		return;
    	}


    	$data->listavailabledb = $aolmdl->GetRequestedDBAccess($reqid);
    	$data->featurepageloc = $data->base_url.$this->aolapiindexpage;
		$data->listdatabase = (isset($response->d)) ? $response->d : array();
		Filebean::AolWriteDebugLog($data,$logindata[0]['username'],'Total Databases: '.count($data->listdatabase));

		$_SESSION['aolfrtoken'] = random_int(1000, 9999);
    	$data->formtoken = $_SESSION['aolfrtoken'];
    	$data->judul = 'AOL Access - DB Selection';
        $data->subtitle = 'Database Selection';
        $data->page = 'aolauth';

        $data->View('aolintegration/authorization/vdbselection.aolauth',$data);
    }

    public function CallbackImplicitToken($reqid){
    	$data = Shipper::getInstance(Mastercfg::getCfgInstance());
    	$data->Model('aolmodel/Aolintegration');
    	
    	$aolmdl = AolIntegrationmdl::getAolIntegrationmdlInstance();

    	$data->Ent('Filebean');
    	$data->Lib('redis/myredis');
    	$newsession = json_decode(getRedisKey("token:".$_COOKIE['fac_token'], $data));
    	$logindata = array(['username'=>$newsession->username,'nama'=>$newsession->nama,'email'=>$newsession->email]);


    	if (isset($_POST['res'])) {
    		if (isset($_POST['res']['url'])) {
    			$myurl = urldecode($_POST['res']['url']);
    			Filebean::AolWriteDebugLog($data,$logindata[0]['username'],'URL Origin: '.$myurl);
    			$data->Ent('Aolimplicitauthbean');
    			// get acc id

    			// make old token invalid
    			$accid = $aolmdl->MakeOldTokenInvalidByReqID($reqid);
    			Filebean::AolWriteDebugLog($data,$logindata[0]['username'],'Account ID: '.$accid);
    			$aolmdl->MakeOldTokenInvalid($accid);
    			$obj = new ImplicitAuthBean($myurl);
    			$r = $aolmdl->InsertImplicitAuth($obj->getAccesstoken(),$obj->getTokentype(),$obj->getExpiretime(),$obj->getUserref(),
    				$obj->getUserfullname(),$obj->getUsernickname(),$obj->getUserid(),$obj->getUseremail(),$reqid);

    			Filebean::AolWriteDebugLog($data,$logindata[0]['username'],'Access Token: '.$obj->getAccesstoken());
    			Filebean::AolWriteDebugLog($data,$logindata[0]['username'],'Token Type: '.$obj->getTokentype());
    			Filebean::AolWriteDebugLog($data,$logindata[0]['username'],'Expires: '.$obj->getExpiretime());
    			Filebean::AolWriteDebugLog($data,$logindata[0]['username'],'Referrer: '.$obj->getUserref());
    			Filebean::AolWriteDebugLog($data,$logindata[0]['username'],'Name: '.$obj->getUserfullname());
    			Filebean::AolWriteDebugLog($data,$logindata[0]['username'],'Nickname: '.$obj->getUsernickname());
    			Filebean::AolWriteDebugLog($data,$logindata[0]['username'],'Mobile: '.$obj->getUsermobile());
    			Filebean::AolWriteDebugLog($data,$logindata[0]['username'],'ID: '.$obj->getUserid());
    			Filebean::AolWriteDebugLog($data,$logindata[0]['username'],'Email: '.$obj->getUseremail());

    			if ($r) {
    				Filebean::AolWriteDebugLog($data,$logindata[0]['username'],'Implicit token has been saved.');
    				echo "<script>location.replace('".$data->base_url.$this->responsesuccess.$reqid."');</script>";
    			}else{
    				Filebean::AolWriteErrorLog($data,$logindata[0]['username'],'Failed to save Implicit token.');
    				echo "<script>location.replace('".$data->base_url.$this->responseerr."');</script>";
    			}

    		}
    		return;
    	}
    	$data->judul = 'response from AOL';
    	$data->View('aolintegration/authorization/vresimplicit.aolauth',$data);

    }

    private function CreateImplicitRequest($accid,$clientid,$scopes){
    	$data = Shipper::getInstance(Mastercfg::getCfgInstance());
    	$data->Model('aolmodel/Aolintegration');
    	$aolmdl = AolIntegrationmdl::getAolIntegrationmdlInstance();
    	
		$data->Ent('Filebean');
		$data->Lib('redis/myredis');
    	$newsession = json_decode(getRedisKey("token:".$_COOKIE['fac_token'], $data));
    	$logindata = array(['username'=>$newsession->username,'nama'=>$newsession->nama,'email'=>$newsession->email]);

		Filebean::AolWriteDebugLog($data,$logindata[0]['username'],'ClientID: '.$clientid);

    	$id = md5($accid.$scopes.date('Y-m-d H:i:s'));
    	Filebean::AolWriteDebugLog($data,$logindata[0]['username'],'Generated ID: '.$id);
    	
    	$basicurl = "https://account.accurate.id/oauth/authorize";
    	Filebean::AolWriteDebugLog($data,$logindata[0]['username'],'Main URL: '.$basicurl);
    	$redirecturl = $data->base_url.$this->callbackpage.$id;
    	$params = "?response_type=token&client_id=".$clientid."&redirect_uri=".$redirecturl."&scope=".$scopes;
    	Filebean::AolWriteDebugLog($data,$logindata[0]['username'],'Params: '.$params);
    	$aolmdl->RequestFootPrint($id,$accid,$basicurl.$params);
    	return trim($basicurl.$params);
    }

    public function RequestAccesstoAol($id){
    	$data = Shipper::getInstance(Mastercfg::getCfgInstance());
    	$data->Model('aolmodel/Aolintegration');
        $aolmdl = AolIntegrationmdl::getAolIntegrationmdlInstance();
        $selfpage = $data->base_url.$this->reqaccesspage.$id;

        $detailacc = $aolmdl->GetAccountDetail($id);
		$data->Ent('Filebean');
		$data->Lib('redis/myredis');
    	$newsession = json_decode(getRedisKey("token:".$_COOKIE['fac_token'], $data));
    	$logindata = array(['username'=>$newsession->username,'nama'=>$newsession->nama,'email'=>$newsession->email]);
    	

    	if (isset($_POST['req'])) {
    		Filebean::AolWriteDebugLog($data,$logindata[0]['username'],'Requesting access for Accurate API.');
    		if ($_SESSION['aolfrtoken'] == $_POST['req']['token']) {
    			$joinedscope = $aolmdl->GetJoinedScopes($logindata[0]['username']);
    			Filebean::AolWriteDebugLog($data,$logindata[0]['username'],'Scopes: '.$joinedscope[0]['joinedscope']);
    			$accurateapiurl = $this->CreateImplicitRequest($id,$detailacc[0]['clientid'],$joinedscope[0]['joinedscope']);
    			header('Location: '.$accurateapiurl);
    		}else{
    			Filebean::AolWriteDebugLog($data,$logindata[0]['username'],'Form token has been expired.');
    			echo "<script>alert('Your time to submit form has ended, please re-submit the form.');</script>";
    		}
    		
    	}


    	$_SESSION['aolfrtoken'] = random_int(1000, 9999);
    	$data->formtoken = $_SESSION['aolfrtoken'];

    	$data->myscopes = $aolmdl->GetAssignedScopes($logindata[0]['username']);
    	$data->judul = 'AOL Access - Request';
        $data->subtitle = 'Request Access Confirmation';
        $data->page = 'aolauth';

        $data->View('aolintegration/authorization/vreqimplicit.aolauth',$data);
    }

    public function AuthLandingPage(){
    	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
    	$data = Shipper::getInstance(Mastercfg::getCfgInstance());
    	$data->Model('aolmodel/Querybuilder');
    	$data->Model('aolmodel/Aolintegration');
    	$data->Model('Querybuilder');
    	$db = AolQuerybuilder::getAolQueryBuilderInstance();
    	$aolmdl = AolIntegrationmdl::getAolIntegrationmdlInstance();

        $ch = curl_init('https://fac-institute.com/facport/items?q=modules');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $apiResult = json_decode($response, true);

// mapping module new ui
        $modulMap = [];
        foreach ($apiResult['data'] as $row) {
            $modulMap[$row['module']] = $row['items'];
        }
        $data->modul = $modulMap;
//

        $data->Lib('redis/myredis');
    	$newsession = json_decode(getRedisKey("token:".$_COOKIE['fac_token'], $data));
    	$logindata = array(['username'=>$newsession->username,'nama'=>$newsession->nama,'email'=>$newsession->email]);

    	if (count($logindata)<1) {
    		echo "<script>location.replace('".$data->base_url."');</script>";
    		return;
    	}

    	$data->listdata = $aolmdl->GetAccountDetByWorkspace($logindata[0]['username']); 
    	$data->namauser = $logindata[0]['nama'];

    	$data->activitylog = array();//$aolmdl->GetHistoryActivityToday($logindata[0]['username']);
    	$data->batchresponsedet = $data->base_url.$this->resdetpage;
    	$data->resumeworkdbselectpage = $data->base_url.$this->resworkdbselection;

    	$data->Ent('Filebean');
    	Filebean::AolWriteDebugLog($data,$logindata[0]['username'],'accessed landing page.');
    	
    	$data->listdatabase = $aolmdl->LastAccessedDatabase($logindata[0]['username']);
    	$data->acccreate = $aolmdl->CheckEntitlementByName('Create Account',$logindata[0]['username']);
    	$data->reqaccess = $aolmdl->CheckEntitlementByName('Request Access Token',$logindata[0]['username']);
    	$data->reqdbaccess = $aolmdl->CheckEntitlementByName('Request Database Access Token',$logindata[0]['username']);

    	$data->apimenupage = $data->base_url.$this->aolapiindexpage;
    	$data->dbaccesspage = (isset($data->listdatabase[0]['sfkref'])) ? $data->base_url.$this->responsesuccess.$data->listdatabase[0]['sfkref'] : '';

    	$data->linktuts = 'https://drive.google.com/drive/folders/1HiJUzuxKeYDaWLEBUaEIHdk6jKvP0GYa?usp=sharing';

    	$data->judul = 'AOL Integration - Landing Page';
        $data->subtitle = 'Welcome Back, '.$logindata[0]['nama'].'!';
        $data->page = 'landingpage';

//        new ui data
//        $data->page = 'landingpage1';

        $data->registernewapipage = $data->base_url.$this->registerpage;
        $data->requestaccesspage = $data->base_url.$this->reqaccesspage;
//        $data->View('aolintegration/landing-page/vchooseapiobj.aolauth',$data);
//        new ui view
        $data->View('aolintegration/landing-page/landing-page.aolauth',$data);
//         new ui view
    }

    public function Authform(){
    	$data = Shipper::getInstance(Mastercfg::getCfgInstance());
    	$data->Model('aolmodel/Querybuilder');
		$db = AolQuerybuilder::getAolQueryBuilderInstance();

		$data->Ent('Filebean');
		$data->Lib('redis/myredis');
    	$newsession = json_decode(getRedisKey("token:".$_COOKIE['fac_token'], $data));
    	$logindata = array(['username'=>$newsession->username,'nama'=>$newsession->nama,'email'=>$newsession->email]);
    	Filebean::AolWriteDebugLog($data,$logindata[0]['username'],'accessed register API Detail page.');

		$selfpage = $data->base_url.$this->registerpage;
		if (isset($_POST['in'])) {
			Filebean::AolWriteDebugLog($data,$logindata[0]['username'],'Attempting to insert new clientid and clientsecret.');
			if ($_SESSION['aolftoken']==$_POST['in']['formtoken']) {
				$r = $db->InsertData('accounts',[
					'sid' => md5($_POST['in']['email'].$_POST['in']['clientid']),
					'semail' => $_POST['in']['email'],
					'sclientid' => $_POST['in']['clientid'],
					'sclientsecret' => $_POST['in']['clientsecret'],
					'sexternalref' => $_POST['in']['username']
				]);
				if ($r) {
					Filebean::AolWriteDebugLog($data,$logindata[0]['username'],'Data has been successfully saved.');
				}else{
					Filebean::AolWriteErrorLog($data,$logindata[0]['username'],'Failed to save clientid and clientsecret data.');
				}
				echo "<script>location.replace('".$data->base_url."aol-integration');</script>";
				return;
			}else{
				echo "<script>alert('For security reason, please re-enter your detail on the form.');</script>";
				echo "<script>location.replace('".$selfpage."');</script>";
				return;
			}
			
		}

		$_SESSION['aolftoken'] = random_int(1000, 10000);

		$data->formtoken = $_SESSION['aolftoken'];

		$data->username = $logindata[0]['username'];

		$data->judul = 'AOL Integration - Identify Account';
        $data->subtitle = 'AOL Integration - Identify Account';
        $data->page = 'aolauth';
        $data->View('aolintegration/authorization/vindentifyacc.aolauth',$data);
    }


    public function ResumeWorkDatabaseSelection($docname,$batchid){
    	$data = Shipper::getInstance(Mastercfg::getCfgInstance());
    	$data->Model('aolmodel/Aolintegration');
    	$aolmdl = AolIntegrationmdl::getAolIntegrationmdlInstance();

    	$data->Ent('Filebean');
    	$data->Lib('redis/myredis');
    	$newsession = json_decode(getRedisKey("token:".$_COOKIE['fac_token'], $data));
    	$logindata = array(['username'=>$newsession->username,'nama'=>$newsession->nama,'email'=>$newsession->email]);

    	if (isset($_POST['req'])) {
    		if ($_SESSION['aolfrtoken'] == $_POST['req']['token']) {
    			
    			$typeid = substr($batchid,0,2);
    			$typeid = strtolower($typeid);
    			$menuloc = $data->base_url.'aol-integration/aol-menus/';
    			if ($typeid=='ro') {
    				echo "<script>location.replace('".$menuloc."roll-over-send/".$docname."/".$_POST['req']['dbselected']."');</script>";
    			}elseif ($typeid=='cr') {
    				echo "<script>location.replace('".$menuloc."sales-receipt-send/".$docname."/".$_POST['req']['dbselected']."');</script>";
    			}elseif ($typeid=='ia') {
    				echo "<script>location.replace('".$menuloc."item-adjustment-send/".$docname."/".$_POST['req']['dbselected']."');</script>";
    			}elseif ($typeid=='it') {
    				echo "<script>location.replace('".$menuloc."item-transfer-send/".$docname."/".$_POST['req']['dbselected']."');</script>";
    			}elseif ($typeid=='pp') {
    				echo "<script>location.replace('".$menuloc."purchase-payment-send/".$docname."/".$_POST['req']['dbselected']."');</script>";
    			}elseif ($typeid=='jo') {
    				echo "<script>location.replace('".$menuloc."job-order-send/".$docname."/".$_POST['req']['dbselected']."');</script>";
    			}else{
    				echo "<script>location.replace('".$data->base_url."aol-integration/');</script>";
    			}
    			return;
    		}else{
    			Filebean::AolWriteErrorLog($data,$logindata[0]['username'],'Form token has been expired.');
    			echo "<script>alert('Your time to submit form has ended, please re-submit the form.');</script>";
    		}
    		
    	}
    	Filebean::AolWriteDebugLog($data,$logindata[0]['username'],'Resume work - Accessing DB Selection Page.');
    	
    	$canselectdb = $aolmdl->CheckEntitlementByName('Request Database Access Token',$logindata[0]['username']);

    	if (count($canselectdb) < 1) {
    		header('Location:'.$data->base_url.$this->landingpage);
    		return;
    	}


    	$data->listdatabase = $aolmdl->LastAccessedDatabase($logindata[0]['username']);
    	$data->featurepageloc = $data->base_url.$this->aolapiindexpage;
		Filebean::AolWriteDebugLog($data,$logindata[0]['username'],'Total Databases: '.count($data->listdatabase));

		$_SESSION['aolfrtoken'] = random_int(1000, 9999);
    	$data->formtoken = $_SESSION['aolfrtoken'];
    	$data->judul = 'AOL Access - DB Selection';
        $data->subtitle = 'Database Selection';
        $data->page = 'aolauth';

        $data->View('aolintegration/authorization/vdbslctresume.aolauth',$data);
    }

}