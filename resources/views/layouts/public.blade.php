
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Bengaluru Tech Summit 2025</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <link rel="canonical" href="https://www.bengalurutechsummit.com/agenda-test.php" />



    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Libraries Stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide@3.6.0/dist/css/glide.core.min.css">
    <!-- Font Awesome 4.7.0 CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <!-- Customized Bootstrap Stylesheet -->
    <link href="https://www.bengalurutechsummit.com/css/bootstrap.min.css" rel="stylesheet">


    <!-- Template Stylesheet --->
    <link href="https://www.bengalurutechsummit.com/css/style.css?v=1761127284" rel="stylesheet"><style>
        @import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        body {
            font-family: "Barlow Condensed", sans-serif!important;
            font-style: normal;
        }
        /* Day Tab Styles */
        #ag .nav-tabs .nav-link {
            color: #fff;
            background-color: #5F3A8C;
            border-color: #dee2e6 #dee2e6 #fff;
            font-family: "Barlow Condensed", sans-serif;
        }
        #ag .nav-tabs .nav-link.active {
            color: #fff;
            background: linear-gradient(to right, #1F296D, #D02560);
        }
        /* Session/Pill Tab Styles */
        #ag .nav-pills-custom .nav-link {
            color: #c81980;
            background: #fff;
            font-weight: bold;
            /* Matches the look of the pills in the image */
            border: 1px solid #e9ecef;
            border-radius: 8px;
            margin-bottom: 10px;
            padding: 15px 10px;
            text-align: left;
            font-family: "Barlow Condensed", sans-serif;
        }
        #ag .nav-pills-custom .nav-link.active {
            color: #fff;
            background: linear-gradient(to right, #2C3A8C, #F72C70);
            font-weight: bold;
            /* Highlight border for active pill */
            border: 1px solid #912e8b;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .bg-white1 {
            background-color: #fff;
        }
        /* Enhanced Agenda Styles - REQUIRED for the image design */

        .tab-pane h3 {
            color: #912e8b;
            text-transform: uppercase !important;
            font-weight: 700;
            padding-bottom: 10px;
            margin-bottom: 15px;
            font-size: 18px;
            font-family: "Barlow Condensed", sans-serif;
        }
        .pink1 {
            color: #c81980!important;
        }
        .agenda-item {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            font-family: "Barlow Condensed", sans-serif;
        }
        .agenda-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(180deg, #b83034 0%, #071339 100%);
        }
        .agenda-item h4 {
            color: #071339;
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 15px;
            line-height: 1.4;
            font-family: "Barlow Condensed", sans-serif;
        }
        .agenda-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: center;
            font-family: "Barlow Condensed", sans-serif;
        }
        .meta-item {
            display: flex;
            align-items: center;
            background: #fff;
            padding: 8px 15px;
            border-radius: 25px;
            border: 1px solid #e9ecef;
            font-size: 0.9rem;
            font-weight: 500;
            color: #495057;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        .meta-item.time {
            background: #2C3A8C;
            color: #fff;
            border-color: #2C3A8C;
        }
        .meta-item.venue {
            background: #5F3A8C;
            color: #fff;
            border-color: #5F3A8C;
            font-family: "Barlow Condensed", sans-serif;
        }
        .meta-item.type {
            background: #007BFF;
            color: #fff;
            border-color: #007BFF;
        }
        .meta-icon {
            width: 16px;
            height: 16px;
            margin-right: 8px;
            opacity: 0.8;
        }
        .session-description {
            color: #444 !important;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-top: 10px;
            font-style: italic;
            font-family: "Barlow Condensed", sans-serif;
        }
        .speaker-info {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 12px;
            margin-top: 15px;
            border-left: 3px solid #b83034;
            font-family: "Barlow Condensed", sans-serif;
        }
        .speaker-name {
            font-weight: 600;
            color: #071339;
            margin-bottom: 5px;
            font-family: "Barlow Condensed", sans-serif;
        }
        .speaker-title {
            font-size: 0.875rem;
            color: #6c757d;
            font-family: "Barlow Condensed", sans-serif;
        }

        /* --- RESPONSIVE FIXES (NEW) --- */
        @media (max-width: 991.98px) {
            /* Session Pills: Force horizontal scrolling on mobile/tablet */
            #ag .nav-pills-custom {
                flex-direction: row !important; /* Forces pills to be in a row */
                flex-wrap: nowrap; /* Prevents wrapping, forcing scroll */
                overflow-x: auto; /* Enables horizontal scrollbar */
                -webkit-overflow-scrolling: touch;
                padding-bottom: 10px; /* Space for scrollbar */
                margin-bottom: 15px; /* Add margin below pills for separation */
            }
            #ag .nav-pills-custom .nav-link {
                /* Adjust individual pills for horizontal scrolling */
                flex: 0 0 auto;
                min-width: 160px; /* Gives enough width for text */
                margin-right: 10px; /* Space between pills */
                margin-bottom: 0 !important; /* Remove vertical margin when horizontal */
                text-align: center; /* Center text in the horizontal pills */
            }
            /* Day Tabs: Ensure they don't break layout on mobile */
            #dayTabs {
                flex-wrap: nowrap !important;
                overflow-x: auto;
            }
            #dayTabs button {
                flex-shrink: 0;
                min-width: 150px;
            }
        }
        /* Custom CSS class as requested */
        .pg-spk .profile-card {
            /* Ensures consistent vertical spacing and alignment */
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        /* Container for the circular image and its border */
        .pg-spk .circular-image-container {
            /* Define the size of the container (adjust as needed) */
            width: 140px;
            height: 140px;
            padding: 5px;
            /* Create the white/light gray circular border */
            border: 3px solid #e0e0e0;
            border-radius: 50%;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 5px;
            /* Adding box shadow for the subtle depth effect seen in the original images */
            box-shadow: 0 0 0 1px #e0e0e0;
        }
        /* Styling for the actual image inside the container */
        .pg-spk .circular-image {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Ensures the image covers the area without distortion */
            border-radius: 50%; /* Makes the image itself a circle */
        }
        /* Styling for the text/logo placeholder circle */
        .pg-spk .circular-placeholder {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background-color: #f5f5f5; /* Light gray background */
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .pg-spk .placeholder-text {
            font-size: 2.5rem;
            font-weight: 700;
            color: #bdbdbd; /* Gray color for the text */
        }
        /* Styling for the name */
        .pg-spk .name {
            font-size: 0.8rem; /* Larger font for the name */
            font-weight: 700; /* Bold */
            color: #c81980; /* Dark text color */
            margin-bottom: 0.25rem;
        }
        /* Styling for the title/designation */
        .pg-spk .title {
            font-size: 0.7rem;/* Standard font size */
            color: #444; /* Muted color for the title */
            margin-top: 0;
        }

        /* ✅ Mobile (max-width 768px) */
        @media (max-width: 768px) {
            .overflow-auto {
                overflow: auto !important;
            }
        }

        /* ✅ Desktop (min-width 769px) */
        @media (min-width: 769px) {
            .overflow-auto {
                overflow: hidden !important;  /* or overflow: none (not valid) */
            }
        }
    </style>


<style>
    @import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    body {
        font-family: "Barlow Condensed", sans-serif!important;
        font-style: normal;
    }
    /* Day Tab Styles */
    #ag .nav-tabs .nav-link {
        color: #fff;
        background-color: #5F3A8C;
        border-color: #dee2e6 #dee2e6 #fff;
        font-family: "Barlow Condensed", sans-serif;
    }
    #ag .nav-tabs .nav-link.active {
        color: #fff;
        background: linear-gradient(to right, #1F296D, #D02560);
    }
    /* Session/Pill Tab Styles */
    #ag .nav-pills-custom .nav-link {
        color: #c81980;
        background: #fff;
        font-weight: bold;
        /* Matches the look of the pills in the image */
        border: 1px solid #e9ecef;
        border-radius: 8px;
        margin-bottom: 10px;
        padding: 15px 10px;
        text-align: left;
        font-family: "Barlow Condensed", sans-serif;
    }
    #ag .nav-pills-custom .nav-link.active {
        color: #fff;
        background: linear-gradient(to right, #2C3A8C, #F72C70);
        font-weight: bold;
        /* Highlight border for active pill */
        border: 1px solid #912e8b;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .bg-white1 {
        background-color: #fff;
    }
    /* Enhanced Agenda Styles - REQUIRED for the image design */
        
    .tab-pane h3 {
        color: #912e8b;
        text-transform: uppercase !important;
        font-weight: 700;
    <?php /*?> border-bottom: 3px solid #b83034;<?php */?> padding-bottom: 10px;
        margin-bottom: 15px;
        font-size: 18px;
        font-family: "Barlow Condensed", sans-serif;
    }
    .pink1 {
        color: #c81980!important;
    }
    .agenda-item {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        border: 1px solid #e9ecef;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        font-family: "Barlow Condensed", sans-serif;
    }
    .agenda-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
        background: linear-gradient(180deg, #b83034 0%, #071339 100%);
    }
    .agenda-item h4 {
        color: #071339;
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 15px;
        line-height: 1.4;
        font-family: "Barlow Condensed", sans-serif;
    }
    .agenda-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        align-items: center;
        font-family: "Barlow Condensed", sans-serif;
    }
    .meta-item {
        display: flex;
        align-items: center;
        background: #fff;
        padding: 8px 15px;
        border-radius: 25px;
        border: 1px solid #e9ecef;
        font-size: 0.9rem;
        font-weight: 500;
        color: #495057;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    .meta-item.time {
        background: #2C3A8C;
        color: #fff;
        border-color: #2C3A8C;
    }
    .meta-item.venue {
        background: #5F3A8C;
        color: #fff;
        border-color: #5F3A8C;
        font-family: "Barlow Condensed", sans-serif;
    }
    .meta-item.type {
        background: #007BFF;
        color: #fff;
        border-color: #007BFF;
    }
    .meta-icon {
        width: 16px;
        height: 16px;
        margin-right: 8px;
        opacity: 0.8;
    }
    .session-description {
        color: #444 !important;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-top: 10px;
        font-style: italic;
        font-family: "Barlow Condensed", sans-serif;
    }
    .speaker-info {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 12px;
        margin-top: 15px;
        border-left: 3px solid #b83034;
        font-family: "Barlow Condensed", sans-serif;
    }
    .speaker-name {
        font-weight: 600;
        color: #071339;
        margin-bottom: 5px;
        font-family: "Barlow Condensed", sans-serif;
    }
    .speaker-title {
        font-size: 0.875rem;
        color: #6c757d;
        font-family: "Barlow Condensed", sans-serif;
    }
    
    /* --- RESPONSIVE FIXES (NEW) --- */
    @media (max-width: 991.98px) {
    /* Session Pills: Force horizontal scrolling on mobile/tablet */
    #ag .nav-pills-custom {
        flex-direction: row !important; /* Forces pills to be in a row */
        flex-wrap: nowrap; /* Prevents wrapping, forcing scroll */
        overflow-x: auto; /* Enables horizontal scrollbar */
        -webkit-overflow-scrolling: touch;
        padding-bottom: 10px; /* Space for scrollbar */
        margin-bottom: 15px; /* Add margin below pills for separation */
    }
    #ag .nav-pills-custom .nav-link {
        /* Adjust individual pills for horizontal scrolling */
        flex: 0 0 auto;
        min-width: 160px; /* Gives enough width for text */
        margin-right: 10px; /* Space between pills */
        margin-bottom: 0 !important; /* Remove vertical margin when horizontal */
        text-align: center; /* Center text in the horizontal pills */
    }
    /* Day Tabs: Ensure they don't break layout on mobile */
    #dayTabs {
        flex-wrap: nowrap !important;
        overflow-x: auto;
    }
    #dayTabs button {
        flex-shrink: 0;
        min-width: 150px;
    }
    }
    /* Custom CSS class as requested */
    .pg-spk .profile-card {
        /* Ensures consistent vertical spacing and alignment */
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    /* Container for the circular image and its border */
    .pg-spk .circular-image-container {
        /* Define the size of the container (adjust as needed) */
        width: 140px;
        height: 140px;
        padding: 5px;
        /* Create the white/light gray circular border */
        border: 3px solid #e0e0e0;
        border-radius: 50%;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 5px;
        /* Adding box shadow for the subtle depth effect seen in the original images */
        box-shadow: 0 0 0 1px #e0e0e0;
    }
    /* Styling for the actual image inside the container */
    .pg-spk .circular-image {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Ensures the image covers the area without distortion */
        border-radius: 50%; /* Makes the image itself a circle */
    }
    /* Styling for the text/logo placeholder circle */
    .pg-spk .circular-placeholder {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background-color: #f5f5f5; /* Light gray background */
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .pg-spk .placeholder-text {
        font-size: 2.5rem;
        font-weight: 700;
        color: #bdbdbd; /* Gray color for the text */
    }
    /* Styling for the name */
    .pg-spk .name {
        font-size: 0.8rem; /* Larger font for the name */
        font-weight: 700; /* Bold */
        color: #c81980; /* Dark text color */
        margin-bottom: 0.25rem;
    }
        
        .pg-spk .roll {
        font-size: 0.8rem; /* Larger font for the name */
        font-weight: 700; /* Bold */
        color: #2c3a8c; /* Dark text color */
        margin-bottom: 0rem;
    }
        
        
        
    /* Styling for the title/designation */
    .pg-spk .title {
        font-size: 0.7rem;/* Standard font size */
        color: #444; /* Muted color for the title */
        margin-top: 0;
    }
    
    /* ✅ Mobile (max-width 768px) */
    @media (max-width: 768px) {
    .overflow-auto {
        overflow: auto !important;
    }
    }
    
    /* ✅ Desktop (min-width 769px) */
    @media (min-width: 769px) {
    .overflow-auto {
        overflow: hidden !important;  /* or overflow: none (not valid) */
    }
    }
        
    
        .gradient-btn2 {
          display: inline-block;
          padding: 0.6rem 1.5rem;
          border-radius: 50px;
          font-weight: 500;
          color: #fff;
          background: linear-gradient(to right, #6e00ff, #ff3caa);
          border: none;
          transition: background 0.1s ease-in-out;
        }
    
        .gradient-btn2:hover,
        .gradient-btn2:focus {
          background: linear-gradient(to left, #6e00ff, #ff3caa);
          color: #fff;
        }
    
    
        
        .pink1 {
    color: #c81980 !important;
}
        
        
    </style>



    <!-- End Meta Pixel Code -->
</head>

<body>
<main class="flex-1 p-8">
    @if(session('success'))
        <div class="p-3 bg-green-100 text-green-800 rounded mb-4 shadow">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="p-3 bg-red-100 text-red-800 rounded mb-4">{{ session('error') }}</div>
    @endif

    <!-- Content placeholder -->
    @yield('content')
</main>

</body>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js" ></script>


<!-- Template Javascript -->
<script src="https://www.bengalurutechsummit.com/js/main.js" defer></script>

<script>
    AOS.init();
</script>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Initial state matching the first tabs
    let currentDay = "day1";
    let currentSession = "Trends";

    // Handle day switch (Horizontal Tabs)
    document.querySelectorAll("#dayTabs .nav-link").forEach(btn => {
        btn.addEventListener("click", function() {
            // Update active state of Day Tabs (Bootstrap handles the large block switch, but we control the look)
            document.querySelectorAll("#dayTabs .nav-link").forEach(b => b.classList.remove("active"));
            this.classList.add("active");

            currentDay = this.getAttribute("data-day");
            showContent();
        });
    });

    // Handle session switch (Vertical Pills)
    document.querySelectorAll("#sessionTabs .nav-link").forEach(btn => {
        btn.addEventListener("click", function() {
            // Update active state of Session Pills
            document.querySelectorAll("#sessionTabs .nav-link").forEach(b => b.classList.remove("active"));
            this.classList.add("active");

            currentSession = this.getAttribute("data-session");
            showContent();
        });
    });

    // Main function to show the combined content pane
    function showContent() {
        // Hide all content panes
        document.querySelectorAll("#agendaContent .tab-pane").forEach(pane => {
            pane.classList.remove("show","active");
        });

        // Construct the ID for the target content pane (e.g., #day1-Plenary)
        let id = `#${currentDay}-${currentSession}`;

        // Show the target content pane
        const targetPane = document.querySelector(id);
        if (targetPane) {
            targetPane.classList.add("show","active");
        }
    }
</script>

</html>

