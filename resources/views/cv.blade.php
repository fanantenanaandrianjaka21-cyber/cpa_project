<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GPTic CPA</title>
    <link rel="stylesheet" href="cvstyle.css">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>

<body>

    <div class="container">

        <!-- CV 1 -->
        <div class="cv">
            <div class="header">
                <h2>ONJAMALALA Sahala</h2>
                <p>Etudiante informatique</p>
            </div>

            <h3>Profil</h3>
            <p>Passionné de développement web, connaissance en dévelopement Front-End et back-End</p>

            <p>Passionné de développement web, connaissance en devellopement Front-End et back-End</p>
            <h3>Compétences</h3>
            <ul>
                <li>HTML / CSS / JavaScript</li>
                <li>PHP / Java / C# / C++</li>
                <li>Laravel / BootStrap</li>
            </ul>

            <h3>Expérience</h3>
            <ul>
                <li>Projet Universitaire:</li>
                <ul>
                    <li>Devellopement de site web (2023-2024)</li>
                    <li>Devellopement de jeu de quiz (2023-2024)</li>
                    <li>Elaboration d'une application de gestion de station essence (2024-2025)</li>
                    <li>Elaboration d'une application de gestion de bibliothèque (2024-2025)</li>
                    <li>Elaboration d'une application de gestion de paiement de salaire des salariés (2024-2025)</li>
                </ul>
                <li>Stage pour l'élaboration d'une application de gestion de parc informatique et du ticketing</li>
            </ul>

            <h3>Contact</h3>
            <p>Email : onjamalalasahala@gmail.com</p>
            <table>
                <tr>
                    <td>Téléphone :</td>
                    <td>+261 34 36 910 05</td>
                </tr>
                <tr>
                    <td></td>
                    <td>+261 33 66 286 86</td>
                </tr>
            </table>
        </div>

        <!-- CV 2 -->
        <div class="cv">
            <div class="header">
                <h2>ANDRIANJAKA Fanantenana</h2>
                <p>Informaticien</p>
                @php
                    $userImage = Auth::user()->image;
                @endphp


            </div>
            <div class="row mr-2">
                <div class="col-md-6">
            <h3>Profil</h3>
            <p>Créative et polyvalente, spécialisée en design graphique et communication visuelle.</p>

                </div>
                <div class="col-md-6 ">

                    <div class="p-2 text-center">
                        <img src="{{ $userImage && file_exists(public_path('storage/' . $userImage))
                            ? asset('storage/' . $userImage)
                            : asset('asset/imageNotfound.jpg') }}"
                            style="max-width: 200px;max-height: 200px;min-width: 200px;min-height: 200px;"
                            class="img-fluid border rounded-circle w-75 p-2 mb-4">
                    </div>
                </div>

            </div>

            <h3>Compétences</h3>
            <ul>
                <li>Photoshop / Illustrator / Figma</li>
                <li>Branding & Identité visuelle</li>
                <li>Mise en page & Affiches</li>
            </ul>

            <h3>Expérience</h3>
            <ul>
                <li>Graphiste – Creativa Agency (2021–2024)</li>
                <li>Designer Freelance (2019–2021)</li>
            </ul>

            <h3>Contact</h3>
            <p>Email : andrianjakafanantenana21@gmail.com</p>
            <table>
                <tr>
                    <td>Téléphone :</td>
                    <td>+261 34</td>
                </tr>
                <tr>
                    <td></td>
                    <td>+261 33</td>
                </tr>
            </table>
        </div>

    </div>

</body>

</html>
