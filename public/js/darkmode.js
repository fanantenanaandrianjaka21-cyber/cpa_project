 // dark mode 
       
            const toggleBtn = document.getElementById("darkModeToggle");
            const body = document.body;

            // Vérifier si le mode sombre est déjà activé (sauvegarde dans localStorage)
            if (localStorage.getItem("theme") === "dark") {
                body.classList.add("dark-mode");
                toggleBtn.textContent = "☀️ Mode Clair";
            }

            toggleBtn.addEventListener("click", () => {
                body.classList.toggle("dark-mode");

                if (body.classList.contains("dark-mode")) {
                    toggleBtn.textContent = "☀️ Mode Clair";
                    localStorage.setItem("theme", "dark");
                } else {
                    toggleBtn.textContent = "🌙 Mode Sombre";
                    localStorage.setItem("theme", "ligth");
                }
            });
