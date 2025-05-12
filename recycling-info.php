<!-- recycling-info.html -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Recycling Information</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    html, body {
      height: 100%;
    }
    body {
      display: flex;
      flex-direction: column;
    }
    main {
      flex: 1;
    }
    .fade-up {
      animation: fadeUp 1s ease-out forwards;
      opacity: 0;
      transform: translateY(30px);
    }
    @keyframes fadeUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

  <!-- Navbar -->
  <nav class="bg-green-700 text-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
      <a href="home.html" class="text-2xl font-bold flex items-center space-x-2">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2"
          viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M9 17v-4a2 2 0 012-2h2a2 2 0 012 2v4m4 0v-4a6 6 0 00-12 0v4m4 0h4"></path>
        </svg>
        <span>JeevanSafa</span>
      </a>
      <div class="space-x-5 text-sm font-medium hidden md:block">
        <div class="space-x-5 text-sm font-medium hidden md:block">
          <a href="home.html" class="hover:underline">Home</a>
          <a href="request-pickup.html" class="hover:underline">Request Pickup</a>
          <a href="schedule.html" class="hover:underline">Schedule</a>
          <a href="profile.html" class="hover:underline">Profile</a>
          <a href="recycling-info.html" class="hover:underline">Recycling Info</a>
          <a href="help.html" class="hover:underline">Help</a>
          <a href="login.html" class="hover:underline">Logout</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="flex-grow">
    <!-- Header -->
    <header class="bg-green-100 py-10 text-center fade-up">
      <h1 class="text-4xl font-bold text-green-700 mb-2">Recycling Information</h1>
      <p class="text-gray-600">Everything you need to know about waste recycling</p>
    </header>

    <!-- Content Section -->
    <section class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md mt-6 fade-up">
      <h2 class="text-2xl font-semibold text-green-700 mb-4">Why Recycling Matters</h2>
      <p class="text-gray-700 mb-6">Recycling helps reduce waste, conserve natural resources, and lower pollution levels. Proper waste segregation ensures that materials like plastic, paper, and glass are reused instead of ending up in landfills.</p>
      
      <h3 class="text-xl font-semibold text-green-600 mb-2">Types of Recyclable Materials</h3>
      <ul class="list-disc ml-6 text-gray-700 mb-6">
        <li>Paper & Cardboard</li>
        <li>Plastic Bottles & Containers</li>
        <li>Glass Bottles & Jars</li>
        <li>Metal Cans & Foils</li>
        <li>Electronics & Batteries (Proper Disposal Required)</li>
      </ul>
      
      <h3 class="text-xl font-semibold text-green-600 mb-2">How to Recycle Effectively</h3>
      <ul class="list-disc ml-6 text-gray-700">
        <li>Rinse food containers before recycling.</li>
        <li>Separate biodegradable and non-biodegradable waste.</li>
        <li>Do not mix hazardous waste with regular recyclables.</li>
        <li>Follow local recycling guidelines for electronic waste disposal.</li>
      </ul>
    </section>
  </main>

  <!-- Footer -->
  <footer class="bg-green-700 text-white py-6 fade-up">
    <div class="max-w-6xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center">
      <p class="text-sm">&copy; 2025 EcoWaste. All rights reserved.</p>
    </div>
  </footer>

</body>
</html>
