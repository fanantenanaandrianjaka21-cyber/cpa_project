# Chemin vers php-win.exe
$php = "C:\xampp\php\php-win.exe"

# Chemin complet vers artisan
$artisan = "E:\cpa\CPA_Project Excel\artisan"

# Dossier de travail du projet
$workingDir = "E:\cpa\CPA_Project Excel"

# Exécuter le scheduler en arrière-plan et silencieusement
Start-Process $php `
    -ArgumentList "`"$artisan`" schedule:run" `
    -WorkingDirectory $workingDir `
    -WindowStyle Hidden
