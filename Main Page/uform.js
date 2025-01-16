function changeLanguage(language) {
    const translations = {
        bm: {
            headerTitle: "SISTEM TEMPAHAN PERALATAN MAKMAL CCSE",
            adminLogin: "Log Masuk Admin",
            home: "Halaman Utama",
            formTitle: "Borang Kebenaran Pelepasan Peralatan",
            labName: "Nama Makmal / Bilik / Tempat:",
            departurePurpose: "Tujuan Pelepasan:",
            maintenance: "Penyelenggaraan",
            recovery: "Pemulihan",
            borrowing: "Peminjaman",
            others: "Lain-lain",
            name: "Nama Pengambil:",
            icNumber: "No. Matrik:",
            date: "Tarikh Peralatan Diambil:",
            phoneNumber: "Telefon / HP:",
            next: "Seterusnya",
        },
        eng: {
            headerTitle: "CCSE LAB EQUIPMENT BOOKING SYSTEM",
            adminLogin: "Admin Login",
            home: "Home",
            formTitle: "Equipment Form",
            labName: "Name of Laboratory / Room / Place:",
            departurePurpose: "Purpose of Departure:",
            maintenance: "Maintenance",
            recovery: "Recovery",
            borrowing: "Borrowing",
            others: "Others",
            name: "Name:",
            icNumber: "Matric Number:",
            date: "Date Equipment Collected:",
            phoneNumber: "Phone Number:",
            next: "Next",
        },
    };

    const text = translations[language];

    // Update text elements
    document.getElementById("header-title").textContent = text.headerTitle;
    document.getElementById("admin-btn").textContent = text.adminLogin;
    document.querySelector(".home-btn").textContent = text.home;
    document.getElementById("form-title").textContent = text.formTitle;
    document.getElementById("label-labName").textContent = text.labName;
    document.getElementById("label-departurePurpose").textContent = text.departurePurpose;

    // Update checkbox labels only
    const checkboxLabels = document.querySelectorAll(".checkbox-group label");
    const purposes = [text.maintenance, text.recovery, text.borrowing, text.others];
    checkboxLabels.forEach((label, index) => {
        if (label.querySelector("input")) {
            label.lastChild.textContent = ` ${purposes[index]}`;
        }
    });

    document.getElementById("label-name").textContent = text.name;
    document.getElementById("label-icNumber").textContent = text.icNumber;
    document.getElementById("label-date").textContent = text.date;
    document.getElementById("label-phoneNumber").textContent = text.phoneNumber;
    document.getElementById("next-btn").textContent = text.next;
}
