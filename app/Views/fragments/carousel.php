<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bootstrap 5 – Dialog & Illustration</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        /* Gunakan font-weight lebih tebal dan kontras tinggi */
        .card-body h4,
        .card-body p {
            color: #212529; /* Warna abu tua (bootstrap text color default) */
            font-weight: 500; /* Medium untuk judul, tetap ringan untuk paragraf */
            line-height: 1.6;
        }

        .card-body p {
            font-size: 1rem;       /* Sedikit lebih besar */
            color: #4b4b4b;         /* Abu sedang agar tidak terlalu gelap */
        }

        .btn-group-custom button {
            font-weight: 500;
        }

        .bg-light-purple {
            background-color: #f1ebf9;
        }

        .rounded-card {
            border-radius: 24px;
        }

        .card-body {
            padding: 2.5rem;
        }

        .align-row {
            min-height: 300px;
        }

        .card-text {
            margin-bottom: 2rem;
        }

        .btn-group-custom {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }
    </style>
</head>

<body class="bg-light">
<div class="container py-5">
    <div class="row align-items-start align-row">

        <!-- Left -->
        <div class="col-lg-7 col-md-12 mb-4 mb-lg-0">
            <div class="bg-light-purple rounded-card w-100 h-100">
                <div class="card-body">
                    <h4 id="cardTitle" class="fw-semibold mb-3">Basic dialog title</h4>
                    <p id="cardBody" class="card-text">A dialog is a type of modal window that appears in front of app content to provide critical information, or prompt for a decision to be made.</p>
                    <div class="btn-group-custom">
                        <button id="action2Button" class="btn btn-link text-decoration-none">Action 2</button>
                        <button id="action1Button" class="btn btn-link text-decoration-none">Action 1</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right -->
        <div class="col-lg-5 col-md-12 d-flex justify-content-center">
            <img src="<?= base_url('medias/images/Figma-asset3.png') ?>" class="img-fluid alt=" cta image">
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const cardTitle     = document.getElementById("cardTitle");
    const cardBody      = document.getElementById("cardBody");
    const action1Button = document.getElementById("action1Button");
    const action2Button = document.getElementById("action2Button");

    action1Button.addEventListener("click", () => {
        cardTitle.textContent = "Basic dialog title";
        cardBody.textContent  = "A dialog is a type of modal window that appears in front of app content to provide critical information, or prompt for a decision to be made.";


    });

    action2Button.addEventListener("click", () => {
        cardTitle.textContent = "Judul telah diubah oleh Action 2";
        cardBody.textContent  = "isi content 2";
    });
</script>
</body>
</html>
