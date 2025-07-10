<!DOCTYPE html>
<html>
<head>
    <style>
        /* Reset & Variables */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --blue-dark: #004080;
            --blue-light: #F3E8FF;
            --mint-light: #E6FFFA;
            --green-dark: #047857;
            --text-dark: #1F2937;
            --white: #FFFFFF;
            --border-radius: 12px;
            --gap: 16px;
            --container-padding: 24px;
        }

        body {
            font-family: sans-serif;
            color: var(--text-dark);
            line-height: 1.5;
        }

        .container {
            width: min(100% - 2 * var(--container-padding), 1200px);
            margin: 0 auto;
            padding: var(--container-padding);
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button, .btn {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            border: none;
        }

        /* Top bar */
        .top-bar {
            background: var(--blue-dark);
            color: var(--white);
            text-align: center;
            padding: 8px;
            font-size: 0.9rem;
        }

        .top-bar a {
            background: #FFA500;
            color: #000;
            margin-left: 12px;
            padding: 6px 12px;
            border-radius: 4px;
        }

        /* Main nav */
        .main-nav {
            background: var(--white);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .main-nav .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--blue-dark);
        }

        .nav-menu ul {
            display: flex;
            gap: 24px;
        }

        .nav-menu a {
            color: var(--text-dark);
            font-size: 0.95rem;
        }

        .hamburger {
            display: none;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Hero */
        .hero {
            background: var(--blue-light);
            padding: 48px 0;
        }

        .hero-container {
            display: flex;
            align-items: center;
            gap: var(--gap);
        }

        .hero-content {
            flex: 1;
            background: var(--blue-light);
            padding: 24px;
            border-radius: var(--border-radius);
        }

        .hero-content h1 {
            font-size: 1.75rem;
            margin-bottom: 12px;
        }

        .hero-content p {
            font-size: 1rem;
            margin-bottom: 16px;
        }

        .hero-actions {
            display: flex;
            gap: 12px;
        }

        .hero-actions .btn {
            background: transparent;
            color: var(--green-dark);
            font-weight: 600;
        }

        .hero-actions .btn-secondary {
            background: transparent;
            color: var(--text-dark);
        }

        .hero-image img {
            max-width: 100%;
            border-radius: var(--border-radius);
        }

        /* Intro */
        .intro {
            background: var(--mint-light);
            padding: 40px 0;
            text-align: center;
        }

        .intro h2 {
            color: var(--green-dark);
            font-size: 1.6rem;
            margin-bottom: 12px;
        }

        .intro p {
            color: var(--text-dark);
            font-size: 1rem;
        }

        /* Features */
        .features {
            padding: 40px 0;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: var(--gap);
        }

        .feature-item {
            background: var(--white);
            border-radius: var(--border-radius);
            padding: 20px;
            border-left: 4px solid var(--green-dark);
        }

        .feature-item img {
            width: 32px;
            height: 32px;
            margin-bottom: 12px;
        }

        .feature-item h3 {
            font-size: 1.1rem;
            margin-bottom: 8px;
            color: var(--text-dark);
        }

        .feature-item ul {
            list-style: none;
            padding-left: 16px;
        }

        .feature-item ul li::before {
            content: "\2022";
            color: var(--green-dark);
            display: inline-block;
            width: 1em;
            margin-left: -1em;
        }

        ul > li {
            border-top: 1px solid #dee2e6;
            padding: 0.5rem 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-container {
                flex-direction: column;
            }

            .nav-menu ul {
                display: none;
            }

            .hamburger {
                display: block;
            }
        }

        /*css for intro section start*/
        /* full-width mint background */
        .intro-section {
            background-color: #e6f8f3;
        }

        /* constrain text to a comfortable reading width */
        .intro-section .inner {
            max-width: 700px;
            margin: 0 auto;
        }

        .intro-section h2 {
            color: #1f8f4a;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .intro-section p {
            color: #2d3a4b;
            line-height: 1.6;
            margin-bottom: 0;
        }

        /*css for intro section end*/

        /*css style for feature section start */
        .feature-card {
            /* vertical bar di kiri */
            border-start: 4px solid #198754; /* hijau Bootstrap “success” */
        }

        .feature-card .card-body > img {
            width: 32px;
            height: 32px;
        }

        /* bullet custom */
        .feature-card ul {
            list-style: none;
            padding-left: 0;
            margin-bottom: 0;
        }

        .feature-card ul li {
            display: flex;
            align-items: flex-start;
        }

        .feature-card ul li::before {
            content: "\2022";
            color: #6c757d; /* abu‐abu */
            display: inline-block;
            width: 1em;
            margin-right: .5em;
            font-size: .8em;
            line-height: 1.2;
        }

        /*css style for feature section end*/
        .icon {
            width: 2.5rem;
            height: 2.5rem;
        }

        /*css style for cta start*/
        .price-section h5 {
            font-size: 1rem;
            font-weight: 500;
            color: #343a40;
            margin-bottom: 0.5rem;
        }

        .price-section h2 {
            font-size: 2rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 0.75rem;
        }

        .price-section .price {
            font-size: 1.25rem;
            font-weight: 600;
            color: #0056b3;
        }

        .price-section .features-list {
            list-style: none;
            padding: 0;
            margin: 1rem 0;
        }

        .price-section .features-list li {
            padding: 0.5rem 0;
            border-top: 1px solid #dee2e6;
        }

        .price-section .features-list li:first-child {
            border-top: none;
        }

        /*css style for cta end*/
        /*css style for pertanyaan umum start*/
        <
        style >
            /* Link warna biru seperti mockup */
        .faq-section a {
            color: #007bff;
        }

        .faq-section a:hover {
            color: #0056b3;
            text-decoration: none;
        }

        #faqAccordion .btn-link {
            text-decoration: none;
        }

        .card-body > h5 {
            padding-top: 10px
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($data->judul ?? 'Judul Default') ?></title>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script
            src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
    ></script>
    <script
            src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
    ></script>
    <link
            rel="stylesheet"
            href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    >
    <link rel="icon" type="image/png" sizes="64x64" href="<?= base_url('fac-icon-64x64.pgn') ?>">
    <link rel="shortcut icon" href="<?= base_url('fac-icon-64x64.png') ?>" type="image/png">
</head>
<body>

<?= view('nav/navbar')?>
<div class="container-fluid p-1 text-white text-center" style="background: #003a75">
    <?= view('fragments/header') ?>
</div>

<div class="container-fluid p-1 text-white text-center">
    <?= view('fragments/carousel') ?>
</div>


<section class="intro-section py-5 text-center">
    <div class="inner px-3">
        <h2>
            Tinggalkan Cara Manual dan Beralih ke Cara Mudah, Efektif dan Efisien.
        </h2>
        <p>
            Coba Facport sekarang dan rasakan kemudahan impor transaksi ke Accurate Online hanya dalam 1 klik!<br>
            Hemat waktu, minim kesalahan, dan tingkatkan efisiensi bisnis Anda.
        </p>
    </div>
</section>


<section class="features py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Buku Besar -->
            <div class="col-lg-4 col-md-6">
                <div class="card feature-card h-100 rounded">
                    <div class="card-body">
                            <span
                                    class="icon d-inline-flex bg-success text-white rounded align-items-center justify-content-center"
                            >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-book" viewBox="0 0 16 16">
  <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783"/>
</svg>
                            </span>
                        <h5 class="fw-bold">Buku Besar</h5>
                        <ul class="mt-3">
                            <?php foreach ($data->modul['Modul Buku Besar'] ?? [] as $item): ?>
                                <li><?= htmlspecialchars($item['name']) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Manufaktur -->
            <div class="col-lg-4 col-md-6">
                <div class="card feature-card h-100 rounded">
                    <div class="card-body">
                              <span
                                      class="icon d-inline-flex bg-success text-white rounded align-items-center justify-content-center"
                              >
                           <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-gear-fill" viewBox="0 0 16 16">
  <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
</svg>
                            </span>
                        <h5 class="fw-bold">Manufaktur</h5>
                        <ul class="mt-3">
                            <?php foreach ($data->modul['Modul Manufaktur'] ?? [] as $item): ?>
                                <li><?= htmlspecialchars($item['name']) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Kas Bank -->
            <div class="col-lg-4 col-md-6">
                <div class="card feature-card h-100 rounded">
                    <div class="card-body">
                            <span
                                    class="icon d-inline-flex bg-success text-white rounded align-items-center justify-content-center"
                            >
                           <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-bank" viewBox="0 0 16 16">
  <path d="m8 0 6.61 3h.89a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H15v7a.5.5 0 0 1 .485.38l.5 2a.498.498 0 0 1-.485.62H.5a.498.498 0 0 1-.485-.62l.5-2A.5.5 0 0 1 1 13V6H.5a.5.5 0 0 1-.5-.5v-2A.5.5 0 0 1 .5 3h.89zM3.777 3h8.447L8 1zM2 6v7h1V6zm2 0v7h2.5V6zm3.5 0v7h1V6zm2 0v7H12V6zM13 6v7h1V6zm2-1V4H1v1zm-.39 9H1.39l-.25 1h13.72z"/>
</svg>
                            </span>
                        <h5 class="fw-bold">Kas Bank</h5>
                        <ul class="mt-3">
                            <?php foreach ($data->modul['Modul Kas Bank'] ?? [] as $item): ?>
                                <li><?= htmlspecialchars($item['name']) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Modul Pembelian -->
            <div class="col-lg-4 col-md-6">
                <div class="card feature-card h-100 rounded">
                    <div class="card-body">
                            <span
                                    class="icon d-inline-flex bg-success text-white rounded align-items-center justify-content-center"
                            >
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                               class="bi bi-cart-fill" viewBox="0 0 16 16">
  <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
</svg>
                            </span>
                        <h5 class="fw-bold">Modul Pembelian</h5>
                        <ul class="mt-3">
                            <?php foreach ($data->modul['Modul Pembelian'] ?? [] as $item): ?>
                                <li><?= htmlspecialchars($item['name']) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>


                </div>
            </div>

            <!-- Modul Penjualan -->
            <div class="col-lg-4 col-md-6">
                <div class="card feature-card h-100 rounded">
                    <div class="card-body">
                             <span
                                     class="icon d-inline-flex bg-success text-white rounded align-items-center justify-content-center"
                             >
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                               class="bi bi-bag-check-fill" viewBox="0 0 16 16">
  <path fill-rule="evenodd"
        d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0m-.646 5.354a.5.5 0 0 0-.708-.708L7.5 10.793 6.354 9.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0z"/>
</svg>
                            </span>
                        <h5 class="fw-bold">Modul Penjualan</h5>
                        <ul class="mt-3">
                            <?php foreach ($data->modul['Modul Penjualan'] ?? [] as $item): ?>
                                <li><?= htmlspecialchars($item['name']) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Modul Persediaan -->
            <div class="col-lg-4 col-md-6">
                <div class="card feature-card h-100 rounded">
                    <div class="card-body">
                            <span
                                    class="icon d-inline-flex bg-success text-white rounded align-items-center justify-content-center"
                            >
                         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                              class="bi bi-box-seam" viewBox="0 0 16 16">
  <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2zm3.564 1.426L5.596 5 8 5.961 14.154 3.5zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z"/>
</svg>
                            </span>
                        <h5 class="fw-bold">Modul Persediaan</h5>
                        <ul class="mt-3">
                            <?php foreach ($data->modul['Modul Persediaan'] ?? [] as $item): ?>
                                <li><?= htmlspecialchars($item['name']) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <!-- Left: Illustration -->
            <div class="col-md-6 mb-4 mb-md-0">
                <a class="navbar-brand" href="<?= base_url() ?>">
                    <img src="<?= base_url('medias/images/Figma-asset2.png') ?>" class="img-fluid alt=" cta image">
                </a>
            </div>
            <!-- Right: Price Card -->
            <div class="col-md-6 price-section">
                <h5>Harga</h5>
                <h2>Hemat Waktu, Minim Kesalahan, Maksimalkan Akurasi!</h2>
                <p class="price">Rp. 1.700.000 / Tahun</p>
                <ul class="features-list">
                    <li>1 Fitur Transaksi</li>
                    <li>1 User</li>
                    <li>1 Database Accurate</li>
                </ul>
                <a href="#" class="btn btn-primary btn-lg">Pesan Sekarang</a>
            </div>
        </div>
    </div>
</section>

<section class="faq-section py-5">
    <div class="container">
        <h2 class="text-center font-weight-bold mb-4">Pertanyaan Umum</h2>

        <div id="faqAccordion" class="accordion">

            <!-- Item #1 -->
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button
                                class="btn btn-link d-block text-left w-100 font-weight-bold"
                                type="button"
                                data-toggle="collapse"
                                data-target="#collapseOne"
                                aria-expanded="true"
                                aria-controls="collapseOne"
                        >
                            Apa Itu Software Accurate?
                        </button>
                    </h5>
                </div>

                <div
                        id="collapseOne"
                        class="collapse show"
                        aria-labelledby="headingOne"
                        data-parent="#faqAccordion"
                >
                    <div class="card-body">
                        Software Accurate adalah aplikasi akuntansi yang diciptakan oleh putra
                        dan putri Indonesia sejak tahun 1999 bertujuan memudahkan pembukuan
                        untuk segala jenis usaha. Dikembangkan oleh PT Cipta Piranti Sejahtera
                        (PT CPS).
                    </div>
                </div>
            </div>

            <!-- Item #2 -->
            <div class="card">
                <div class="card-header" id="headingTwo">
                    <h5 class="mb-0">
                        <button
                                class="btn btn-link collapsed d-block text-left w-100 font-weight-bold"
                                type="button"
                                data-toggle="collapse"
                                data-target="#collapseTwo"
                                aria-expanded="false"
                                aria-controls="collapseTwo"
                        >
                            Apa Kelebihan Sistem Akuntansi Accurate?
                        </button>
                    </h5>
                </div>
                <div
                        id="collapseTwo"
                        class="collapse"
                        aria-labelledby="headingTwo"
                        data-parent="#faqAccordion"
                >
                    <div class="card-body">
                        <!-- Jawaban untuk pertanyaan kedua -->
                        Accurate Online menawarkan integrasi real‐time antara modul penjualan,
                        pembelian, dan persediaan, sehingga data Anda selalu up‐to‐date.
                    </div>
                </div>
            </div>

            <!-- Item #3 -->
            <div class="card">
                <div class="card-header" id="headingThree">
                    <h5 class="mb-0">
                        <button
                                class="btn btn-link collapsed d-block text-left w-100 font-weight-bold"
                                type="button"
                                data-toggle="collapse"
                                data-target="#collapseThree"
                                aria-expanded="false"
                                aria-controls="collapseThree"
                        >
                            Apa Saja Produk Accurate?
                        </button>
                    </h5>
                </div>
                <div
                        id="collapseThree"
                        class="collapse"
                        aria-labelledby="headingThree"
                        data-parent="#faqAccordion"
                >
                    <div class="card-body">
                        <!-- Jawaban untuk pertanyaan ketiga -->
                        Produk kami mencakup Accurate Desktop, Accurate Online, dan modul tambahan
                        untuk manufaktur, distribusi, dan retail.
                    </div>
                </div>
            </div>

            <!-- Item #4 -->
            <div class="card">
                <div class="card-header" id="headingFour">
                    <h5 class="mb-0">
                        <button
                                class="btn btn-link collapsed d-block text-left w-100 font-weight-bold"
                                type="button"
                                data-toggle="collapse"
                                data-target="#collapseFour"
                                aria-expanded="false"
                                aria-controls="collapseFour"
                        >
                            Bagaimana Cara Menggunakan Accurate?
                        </button>
                    </h5>
                </div>
                <div
                        id="collapseFour"
                        class="collapse"
                        aria-labelledby="headingFour"
                        data-parent="#faqAccordion"
                >
                    <div class="card-body">
                        <!-- Jawaban untuk pertanyaan keempat -->
                        Daftar, pilih paket, instal aplikasi (atau akses via browser), dan ikuti
                        wizard setup untuk mengimpor data awal Anda.
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


</body>
</html>