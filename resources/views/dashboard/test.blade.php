@extends('layouts.dynamique')

@section('content')
{{-- <form class="row g-3 needs-validation" novalidate>
  <div class="col-md-4">
    <label for="validationCustom01" class="form-label">First name</label>
    <input type="text" class="form-control" id="validationCustom01" value="Mark" required>
    <div class="valid-feedback">
      Looks good!
    </div>
  </div>
  <div class="col-md-4">
    <label for="validationCustom02" class="form-label">Last name</label>
    <input type="text" class="form-control" id="validationCustom02" value="Otto" required>
    <div class="valid-feedback">
      Looks good!
    </div>
  </div>
  <div class="col-md-4">
    <label for="validationCustomUsername" class="form-label">Username</label>
    <div class="input-group has-validation">
      <span class="input-group-text" id="inputGroupPrepend">@</span>
      <input type="text" class="form-control" id="validationCustomUsername" aria-describedby="inputGroupPrepend" required>
      <div class="invalid-feedback">
        Please choose a username.
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <label for="validationCustom03" class="form-label">City</label>
    <input type="text" class="form-control" id="validationCustom03" required>
    <div class="invalid-feedback">
      Please provide a valid city.
    </div>
  </div>
  <div class="col-md-3">
    <label for="validationCustom04" class="form-label">State</label>
    <select class="form-select" id="validationCustom04" required>
      <option selected disabled value="">Choose...</option>
      <option>...</option>
    </select>
    <div class="invalid-feedback">
      Please select a valid state.
    </div>
  </div>
  <div class="col-md-3">
    <label for="validationCustom05" class="form-label">Zip</label>
    <input type="text" class="form-control" id="validationCustom05" required>
    <div class="invalid-feedback">
      Please provide a valid zip.
    </div>
  </div>
  <div class="col-12">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
      <label class="form-check-label" for="invalidCheck">
        Agree to terms and conditions
      </label>
      <div class="invalid-feedback">
        You must agree before submitting.
      </div>
    </div>
  </div>
  <div class="col-12">
    <button class="btn btn-primary" type="submit">Submit form</button>
  </div>
</form> --}}
{{-- <form action="/action_page.php" class="was-validated">
  <div class="mb-3 mt-3">
    <label for="uname" class="form-label">Username:</label>
    <input type="text" class="form-control" id="uname" placeholder="Enter username" name="uname" required>
    <div class="valid-feedback">Valid.</div>
    <div class="invalid-feedback">Please fill out this field.</div>
  </div>
  <div class="mb-3">
    <label for="pwd" class="form-label">Password:</label>
    <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd" required>
    <div class="valid-feedback">Valid.</div>
    <div class="invalid-feedback">Please fill out this field.</div>
  </div>
  <div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" id="myCheck" name="remember" required>
    <label class="form-check-label" for="myCheck">I agree on blabla.</label>
    <div class="valid-feedback">Valid.</div>
    <div class="invalid-feedback">Check this checkbox to continue.</div>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form> --}}
{{-- <div class="card shadow-sm border-0">
  <div class="card-body">
    <div class="d-flex align-items-center mb-2">
      <button class="btn btn-light btn-sm me-1"><i class="bi bi-type-bold"></i></button>
      <button class="btn btn-light btn-sm me-1"><i class="bi bi-type-italic"></i></button>
      <button class="btn btn-light btn-sm me-1"><i class="bi bi-link-45deg"></i></button>
      <button class="btn btn-light btn-sm me-1"><i class="bi bi-list-ul"></i></button>
      <button class="btn btn-light btn-sm me-1"><i class="bi bi-code"></i></button>
    </div>
    <textarea class="form-control border-0 shadow-none" rows="3" placeholder="Envoyer un message..."></textarea>
    <div class="d-flex justify-content-between align-items-center mt-2">
      <div>
        <button class="btn btn-light btn-sm"><i class="bi bi-plus-lg"></i></button>
        <button class="btn btn-light btn-sm"><i class="bi bi-emoji-smile"></i></button>
        <button class="btn btn-light btn-sm"><i class="bi bi-paperclip"></i></button>
      </div>
      <button class="btn btn-primary btn-sm rounded-circle">
        <i class="bi bi-send"></i>
      </button>
    </div>
  </div>
</div>
<!-- Barre d'outils -->
<div id="toolbar">
  <span class="ql-formats">
    <button class="ql-bold"></button>
    <button class="ql-italic"></button>
    <button class="ql-link"></button>
    <button class="ql-list" value="ordered"></button>
    <button class="ql-list" value="bullet"></button>
    <button class="ql-code-block"></button>
  </span>
</div>

<!-- Zone d’édition -->
<div id="editor" style="height:120px;"></div>

<!-- Scripts -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
  var quill = new Quill('#editor', {
    modules: { toolbar: '#toolbar' },
    theme: 'snow'
  });
</script>
<!-- Liens Bootstrap et icônes -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"> --}}

{{-- text area --}}
{{-- <!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Éditeur de message</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Quill Editor -->
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

  <style>
    body {
      background: #f9f9f9;
      padding: 40px;
    }
    .message-box {
      max-width: 800px;
      margin: auto;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    #editor {
      height: 120px;
      border: none;
      font-size: 15px;
    }
    .ql-toolbar.ql-snow {
      border: none;
      border-bottom: 1px solid #dee2e6;
      border-radius: 10px 10px 0 0;
    }
    .ql-container.ql-snow {
      border: none;
      border-radius: 0 0 10px 10px;
    }
  </style>
</head>
<body>

  <div class="message-box">
    <!-- Barre d’outils -->
    <div id="toolbar">
      <span class="ql-formats">
        <button class="ql-bold"></button>
        <button class="ql-italic"></button>
        <button class="ql-link"></button>
        <button class="ql-list" value="ordered"></button>
        <button class="ql-list" value="bullet"></button>
        <button class="ql-code-block"></button>
      </span>
    </div>

    <!-- Zone d’édition -->
    <div id="editor"></div>

    <!-- Zone des actions (fichier, emoji, envoi) -->
    <div class="d-flex justify-content-between align-items-center p-2 border-top">
      <div class="d-flex align-items-center gap-2">
        <label class="btn btn-light btn-sm mb-0">
          <i class="bi bi-paperclip"></i>
          <input type="file" id="fileInput" hidden>
        </label>
        <button class="btn btn-light btn-sm"><i class="bi bi-emoji-smile"></i></button>
      </div>

      <button id="sendBtn" class="btn btn-primary btn-sm rounded-circle">
        <i class="bi bi-send"></i>
      </button>
    </div>
  </div>

  <!-- Quill + Bootstrap JS -->
  <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Initialiser Quill
    const quill = new Quill('#editor', {
      modules: { toolbar: '#toolbar' },
      theme: 'snow',
      placeholder: 'Envoyer un message...',
    });

    // Gestion du bouton Envoyer
    document.getElementById('sendBtn').addEventListener('click', () => {
      const message = quill.root.innerHTML.trim();
      const fileInput = document.getElementById('fileInput');
      const file = fileInput.files[0];

      if (!message && !file) {
        alert('Veuillez écrire un message ou joindre un fichier.');
        return;
      }

      console.log('Message:', message);
      if (file) {
        console.log('Fichier joint:', file.name);
      }

      // Exemple : tu peux envoyer avec fetch() vers ton API Laravel ou autre
      // fetch('/api/messages', { method: 'POST', body: formData })

      quill.root.innerHTML = ''; // vider le champ
      fileInput.value = ''; // réinitialiser le fichier
    });
  </script> --}}
{{-- <!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Afficher le nom du fichier</title><script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head> --}}
{{-- <body class="p-4">

<div class="d-flex justify-content-between align-items-center p-2 border-top">
  <div class="d-flex align-items-center gap-2">
    <label class="btn btn-light btn-sm mb-0">
      <i class="bi bi-paperclip"></i> Joindre un fichier
      <input type="file" id="fileInput" hidden>
    </label>
    <span id="fileName" class="text-muted small"></span>
  </div>
</div> --}}

{{-- <script>
  // --- version jQuery ---
  $(document).ready(function() {
    $('#fileInput').on('change', function() {
      const file = this.files[0];
      if (file) {
        $('#fileName').text(file.name);
      } else {
        $('#fileName').text('');
      }
    });
  });
</script>

</body>
</html> --}}
                            {{-- <form method="POST" action="{{ route('ajoutTicketUtilisateur') }}" id="register-form"
                                enctype="multipart/form-data">
                                @csrf
                                    <input class="form-control-file border" type="file" name="image" >
<input type="text" name="test">
           <button type="submit" class="btn btn-success">Envoyer</button>
                            </form> --}}


<?php/*
$texte = "Bonjour";
$deuxieme = $texte[1]; // Les index commencent à 0
echo $deuxieme; // o
// ✅ 2. Avec substr()
// Pour plus de contrôle (utile si la chaîne peut contenir des accents ou si tu veux un comportement clair).

// php
// Copy code
$texte = "Bonjour";
$deuxieme = substr($texte, 1, 1);
echo $deuxieme; // o
// ✅ 3. Avec Str de Laravel
// Si tu veux rester dans l’écosystème Laravel (et profiter du support Unicode), tu peux utiliser Illuminate\Support\Str :

// php
// Copy code
use Illuminate\Support\Str;

$texte = "Bonjour";
$deuxieme = Str::substr($texte, 1, 1);
echo $deuxieme; // o
// ✅ 4. Avec caractères spéciaux (UTF-8 / accents)
// Si ta chaîne contient des caractères accentués (ex: École), il faut utiliser mb_substr() pour éviter les erreurs :

// php
// Copy code
$texte = "École";
$deuxieme = mb_substr($texte, 1, 1, 'UTF-8');
echo $deuxieme; // c

// ✅ 1. Avec substr() (classique PHP)
$texte = "Bonjour";
$deuxPremiers = substr($texte, 0, 2);
echo $deuxPremiers; // Bo

$texte = "Bonjour";
$deuxPremiers = Str::substr($texte, 0, 2);
echo $deuxPremiers; // Bo

// ✅ 3. Avec mb_substr() (si texte UTF-8, ex: caractères accentués)
$texte = "École";
$deuxPremiers = mb_substr($texte, 0, 2, 'UTF-8');
echo $deuxPremiers; // Éc
*/
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>DataTable Local - Filtres en liens</title>

<!-- ✅ Bootstrap 4 CSS en ligne -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- ✅ DataTables CSS et Buttons en ligne -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css">

<style>
  #filters a {
    margin-right: 8px;
    cursor: pointer;
    text-decoration: none;
  }
  #filters a.active {
    font-weight: bold;
    text-decoration: underline;
  }
</style>
</head>
<body class="bg-light p-4">

<div class="container">
  <h3 class="text-center mb-4">DataTable local avec filtres en liens et export</h3>

  <!-- 🔍 Filtres en liens -->
  <div id="filters" class="mb-3"></div>

  <!-- 📊 Tableau -->
  <table id="bootstrap-data-table-export" class="table table-striped table-bordered" style="width:100%">
    <thead class="table-dark">
      <tr>
        <th>Nom</th>
        <th>Position</th>
        <th>Bureau</th>
        <th>Âge</th>
        <th>Date de début</th>
        <th>Salaire</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <tr><td>Tiger Nixon</td><td>System Architect</td><td>Edinburgh</td><td>61</td><td>2011/04/25</td><td>$320,800</td><td><button class="btn btn-sm btn-primary">Modifier</button></td></tr>
      <tr><td>Garrett Winters</td><td>Accountant</td><td>Tokyo</td><td>63</td><td>2011/07/25</td><td>$170,750</td><td><button class="btn btn-sm btn-primary">Modifier</button></td></tr>
      <tr><td>Ashton Cox</td><td>Junior Technical Author</td><td>San Francisco</td><td>66</td><td>2009/01/12</td><td>$86,000</td><td><button class="btn btn-sm btn-primary">Modifier</button></td></tr>
      <tr><td>Cedric Kelly</td><td>Senior Javascript Developer</td><td>Edinburgh</td><td>22</td><td>2012/03/29</td><td>$433,060</td><td><button class="btn btn-sm btn-primary">Modifier</button></td></tr>
      <tr><td>Airi Satou</td><td>Accountant</td><td>Tokyo</td><td>33</td><td>2008/11/28</td><td>$162,700</td><td><button class="btn btn-sm btn-primary">Modifier</button></td></tr>
    </tbody>
  </table>
</div>

<!-- ✅ jQuery et Bootstrap JS en ligne -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<!-- ✅ DataTables et Buttons JS en ligne -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script>
$(document).ready(function() {

});
  var table = $('#bootstrap-data-table-export').DataTable({
    dom: '<"row mb-3"<"col-md-6"B><"col-md-6"f>>rtip',
    buttons: [
      { extend: 'copy', text: 'Copier' },
      { extend: 'csv', text: 'CSV' },
      { extend: 'excel', text: 'Excel' },
      { extend: 'pdf', text: 'PDF' },
      { extend: 'print', text: 'Imprimer' }
    ],
initComplete: function() {
        var api = this.api();
        var container = $('#filters');
        container.empty();
        // Générer les selects de filtre
        api.columns().every(function() {
          var column = this;

          var colTitle = $(column.header()).text();
if (colTitle === 'Action') return;

          var select = $('<div class="col-md-2 mb-2">' +
                           '<label class="form-label fw-bold">' + colTitle + '</label>' +
                           '<select class="form-select form-select-sm">' +
                             '<option value="">Tous</option>' +
                           '</select>' +
                         '</div>')
                         .appendTo(container)
                         .find('select')
                         .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            column.search(val ? '^' + val + '$' : '', true, false).draw();
                         });

          // Remplir chaque select avec les valeurs uniques
          column.data().unique().sort().each(function(d) {
            if (d) select.append('<option value="' + d + '">' + d + '</option>');
          });
        });
      }
  });
</script>

</body>
</html>

@endsection