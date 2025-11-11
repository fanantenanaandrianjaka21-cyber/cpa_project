@REM ""E:\cpa\CPA_Project Excel\artisan"" schedule:run", 0, False

@echo off
REM Lancer le scheduler Laravel en arrière-plan

cmd /c start /min "" "C:\xampp\php\php-win.exe" "E:\cpa\CPA_Project Excel\artisan" schedule:run
