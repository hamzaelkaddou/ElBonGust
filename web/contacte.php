<?php
$host = "localhost";
$dbname = "elbongust";
$user = "elbongust_bd";
$password = "Hamza@SMX2"; 

$missatge_exit = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nom = $_POST['nom'];
    $cognoms = $_POST['cognoms'];
    $email = $_POST['email'];
    $motiu = $_POST['motiu'];
    $missatge = $_POST['missatge'];

    $conn = mysqli_connect($host, $user, $password, $dbname);

    if (!$conn) {
        die("Error de connexió: " . mysqli_connect_error());
    }

    $sql = "INSERT INTO contactes (nom, cognoms, email, motiu, missatge) 
            VALUES ('$nom', '$cognoms', '$email', '$motiu', '$missatge')";

    if (mysqli_query($conn, $sql)) {
        $missatge_exit = "Missatge enviat correctament.";
        
        $per_a = "info@elbongust.cat";
        $assumpte = "Nou contacte de la web: $motiu";
        $cos = "Has rebut un nou missatge:\n\nNom: $nom $cognoms\nEmail: $email\nMotiu: $motiu\nMissatge: $missatge";
        $headers = "From: web@elbongust.cat";

        mail($per_a, $assumpte, $cos, $headers);

        $assumpte_client = "Hem rebut el teu missatge - ElBonGust";
        $cos_client = "Hola $nom,\n\nHem rebut correctament el teu missatge. Et respondrem en menys de 24 hores.\n\nAtentament,\nL'equip d'ElBonGust.";
        mail($email, $assumpte_client, $cos_client, $headers);
    }

    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contacte – ElBonGust</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <style>
    .page-hero::before {
      background-image: url('https://images.unsplash.com/photo-1551218808-94e220e084d2?w=1400&q=80');
    }
    .alert-success { 
        background-color: #d4af37; 
        color: white; 
        border: none; 
        margin-bottom: 20px;
    }
  </style>
</head>
<body>

  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
      <a class="navbar-brand" href="index.html">ElBon<span>Gust</span></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="mainNav">
        <ul class="navbar-nav ms-auto gap-1">
          <li class="nav-item"><a class="nav-link" href="index.html">Inici</a></li>
          <li class="nav-item"><a class="nav-link" href="qui-som.html">Qui Som</a></li>
          <li class="nav-item"><a class="nav-link" href="carta.html">La Carta</a></li>
          <li class="nav-item"><a class="nav-link" href="serveis.html">Serveis</a></li>
          <li class="nav-item"><a class="nav-link active" href="contacte.php">Contacte</a></li>
          <li class="nav-item ms-2">
            <a class="btn btn-gold-fill" href="reserves.html">Reserves</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <header class="page-hero" style="margin-top:72px;">
    <div class="hero-content">
      <h1>Contacte</h1>
      <div class="gold-bar"></div>
      <p>Estem aquí per atendre't</p>
    </div>
  </header>

  <section class="section-dark section-pad">
    <div class="container">
      <div class="row g-5">

        <div class="col-lg-5">
          <h2 class="section-title">Parla amb nosaltres</h2>
          <div class="gold-divider"></div>
          <p class="text-soft">Tens alguna pregunta, vols fer una reserva especial o necessites informació sobre els nostres serveis? Escriu-nos o truca'ns.</p>
          <p class="text-soft">El nostre equip respon en menys de 24 hores.</p>

          <ul class="list-unstyled mt-4">
            <li class="contact-row">
              <div>
                <strong class="label-gold">Adreça</strong>
                <span class="contact-value">Palamós, Costa Brava<br>Girona, Catalunya</span>
              </div>
            </li>
            <li class="contact-row">
              <div>
                <strong class="label-gold">Correu electrònic</strong>
                <span class="contact-value">info@elbongust.cat</span>
              </div>
            </li>
            <li class="contact-row">
              <div>
                <strong class="label-gold">Horaris</strong>
                <span class="contact-value">
                  Dilluns – Divendres: 13:00–15:30 i 20:00–23:00<br>
                  Dissabte: 13:00–16:00 i 20:00–23:30<br>
                  Diumenge: 13:00–16:00<br>
                  <em>Dimarts tancat</em>
                </span>
              </div>
            </li>
          </ul>
        </div>

        <div class="col-lg-6 offset-lg-1">
          <div class="form-card">
            <h4>Envia'ns un missatge</h4>
            <p class="text-soft" style="font-size:.85rem;margin-bottom:2rem;">Resposta garantida en menys de 24 hores</p>

            <?php if ($missatge_exit != ""): ?>
                <div class="alert alert-success">
                    <?php echo $missatge_exit; ?>
                </div>
            <?php endif; ?>

            <form action="contacte.php" method="POST">
              <div class="row g-3">
                <div class="col-sm-6">
                  <label class="form-label">Nom</label>
                  <input type="text" name="nom" class="form-control" placeholder="El teu nom" required>
                </div>
                <div class="col-sm-6">
                  <label class="form-label">Cognoms</label>
                  <input type="text" name="cognoms" class="form-control" placeholder="Els teus cognoms" required>
                </div>
                <div class="col-12">
                  <label class="form-label">Correu electrònic</label>
                  <input type="email" name="email" class="form-control" placeholder="el.teu@email.com" required>
                </div>
                <div class="col-12">
                  <label class="form-label">Motiu del contacte</label>
                  <select name="motiu" class="form-select" required>
                    <option value="">Selecciona una opció</option>
                    <option value="Reserva de taula">Reserva de taula</option>
                    <option value="Esdeveniment privat">Esdeveniment privat</option>
                    <option value="Catering">Catering</option>
                    <option value="Àpat d'empresa">Àpat d'empresa</option>
                    <option value="Informació sobre la carta">Informació sobre la carta</option>
                    <option value="Altra consulta">Altra consulta</option>
                  </select>
                </div>
                <div class="col-12">
                  <label class="form-label">Missatge</label>
                  <textarea name="missatge" class="form-control" rows="4" placeholder="Explica'ns en què et podem ajudar..." required></textarea>
                </div>
                <div class="col-12 mt-1">
                  <button type="submit" class="btn btn-gold-fill w-100" style="padding:.85rem;">
                    Enviar missatge
                  </button>
                  <p class="form-note">
                    Les teves dades seran tractades de manera confidencial i no seran cedides a tercers.
                  </p>
                </div>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>