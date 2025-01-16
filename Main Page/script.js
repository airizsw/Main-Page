function changeLanguage(language) {
    const translations = {
        bm: {
            headerTitle: "SISTEM TEMPAHAN PERALATAN MAKMAL CCSE",
            adminLogin: "Log Masuk Admin",
            homeButton: "Halaman Utama",
            laboratories: "Makmal",
            labLinks: [
                "Makmal Kejuruteraan Komputer & Sistem Tertanam",
                "Makmal Kejuruteraan Sistem Multimedia",
                "Makmal Kejuruteraan Sistem Pintar",
                "Bengkel Kejuruteraan Komputer & Sistem Komunikasi"
            ],
            applications: "Permohonan",
            applicationForm: "Borang Permohonan",
            searchPlaceholder: "Cari peralatan",
            searchButton: "Cari",
            footer: "&copy; 2025 Hak Cipta Terpelihara. | oleh KUMPULAN 1"
        },
        eng: {
            headerTitle: "CCSE LAB EQUIPMENT BOOKING SYSTEM",
            adminLogin: "Admin Login",
            homeButton: "Home",
            laboratories: "Laboratories",
            labLinks: [
                "Computer & Embedded Systems Engineering Laboratory",
                "Multimedia Systems Engineering Laboratory",
                "Intelligent Systems Engineering Laboratory",
                "Computer & Communication Systems Engineering Workshop"
            ],
            applications: "Applications",
            applicationForm: "Application Form",
            searchPlaceholder: "Search the equipment",
            searchButton: "Search",
            footer: "&copy; 2025 Copyright. All Rights Reserved. | by GROUP 1"
        }
    };

    const selectedLang = translations[language];

    // Update header
    document.getElementById("header-title").textContent = selectedLang.headerTitle;
    document.getElementById("admin-btn").textContent = selectedLang.adminLogin;
    document.querySelector(".home-btn").textContent = selectedLang.homeButton;

    // Update sidebar
    document.querySelector(".sidebar h3").textContent = selectedLang.laboratories;
    const labLinks = document.querySelectorAll(".sidebar ul:first-of-type li a");
    labLinks.forEach((link, index) => {
        link.textContent = selectedLang.labLinks[index];
    });

    document.querySelector(".sidebar h3:nth-of-type(2)").textContent = selectedLang.applications;
    document.querySelector(".sidebar ul:nth-of-type(2) li a").textContent = selectedLang.applicationForm;

    // Update search button
    document.getElementById("search-button").textContent = selectedLang.searchButton;

    // Update search placeholder
    document.querySelector(".search-bar input").placeholder = selectedLang.searchPlaceholder;

    // Update footer
    document.querySelector("footer").innerHTML = selectedLang.footer;
}
