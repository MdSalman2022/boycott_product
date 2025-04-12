<?php
// about.php
require_once 'includes/header.php';
?>

<div class="container mx-auto px-4 py-12 max-w-6xl">
    <!-- Hero Section -->
    <div class="relative mb-16">
        <div class="bg-gradient-to-r from-red-600 to-red-700 rounded-xl p-10 text-white">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">About Our Mission</h1>
            <p class="text-xl max-w-3xl">Empowering consumers with knowledge to make informed choices about the products they purchase.</p>
        </div>
        <div class="absolute -bottom-10 right-10 hidden md:block">
            <img src="assets/images/boycott-icon.png" alt="Boycott Icon" class="w-32 h-32 object-contain" onerror="this.src='https://via.placeholder.com/128?text=Boycott'">
        </div>
    </div>

    <!-- Our Story -->
    <div class="mb-16">
        <h2 class="text-3xl font-bold mb-6 text-gray-800">Our Story</h2>
        <div class="bg-white rounded-lg shadow-md p-8">
            <p class="text-gray-700 mb-4">Our platform was created to provide consumers with transparent information about products that are linked to companies supporting or benefiting from the oppression of Palestinians.</p>
            <p class="text-gray-700 mb-4">We believe in the power of consumer choice and the right to make purchasing decisions aligned with ethical values. By highlighting Israeli products and offering alternatives, we empower individuals to participate in peaceful economic activism.</p>
            <p class="text-gray-700">Our database is continuously updated by our community and verified by our team to ensure accuracy and relevance.</p>
        </div>
    </div>

    <!-- How It Works -->
    <div class="mb-16">
        <h2 class="text-3xl font-bold mb-6 text-gray-800">How Our Platform Works</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6 flex flex-col items-center">
                <div class="bg-red-100 p-3 rounded-full mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-gray-800">Identify</h3>
                <p class="text-gray-600 text-center">We identify and list products that are manufactured by Israeli companies or those that directly support Israeli policies.</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 flex flex-col items-center">
                <div class="bg-blue-100 p-3 rounded-full mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16l2.879-2.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-gray-800">Research</h3>
                <p class="text-gray-600 text-center">Our team researches and verifies product information, ensuring that our database is accurate and up-to-date.</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 flex flex-col items-center">
                <div class="bg-green-100 p-3 rounded-full mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-gray-800">Suggest Alternatives</h3>
                <p class="text-gray-600 text-center">We provide ethical alternatives to these products, making it easier for consumers to make conscious purchasing decisions.</p>
            </div>
        </div>
    </div>

    <!-- Why Boycott -->
    <div class="mb-16">
        <h2 class="text-3xl font-bold mb-6 text-gray-800">Why Support the Boycott?</h2>
        <div class="bg-white rounded-lg shadow-md p-8">
            <p class="text-gray-700 mb-4">Economic boycotts have a long history as a peaceful form of protest. By choosing not to purchase products from companies that contribute to or benefit from human rights violations, consumers can collectively make a powerful statement.</p>
            <p class="text-gray-700 mb-4">Our platform supports the Boycott, Divestment, Sanctions (BDS) movement, which seeks to end international support for Israel's policies of occupation and apartheid against Palestinians.</p>
            <p class="text-gray-700">By making informed choices about the products you buy, you can align your consumer behavior with your values and contribute to a more just world.</p>
        </div>
    </div>

    <!-- Contribute Section -->
    <div class="mb-16">
        <h2 class="text-3xl font-bold mb-6 text-gray-800">How You Can Contribute</h2>
        <div class="bg-white rounded-lg shadow-md p-8">
            <div class="flex flex-col md:flex-row md:items-center">
                <div class="md:w-2/3 md:pr-8">
                    <p class="text-gray-700 mb-4">Our database grows stronger with community contributions. If you know of an Israeli product that should be listed, or an ethical alternative that others should know about, we encourage you to share that information.</p>
                    <p class="text-gray-700 mb-4">Your suggestions help us maintain an accurate and comprehensive resource for everyone committed to ethical consumption.</p>
                    <div class="flex flex-wrap gap-4 mt-6">
                        <a href="suggest-product.php" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg transition duration-300">Suggest a Product</a>
                        <a href="contact.php" class="bg-gray-700 hover:bg-gray-800 text-white px-6 py-2 rounded-lg transition duration-300">Contact Us</a>
                    </div>
                </div>
                <div class="md:w-1/3 mt-6 md:mt-0">
                    <img src="assets/images/contribute.png" alt="Contribute" class="w-full h-auto rounded-lg shadow" onerror="this.src='https://via.placeholder.com/400x300?text=Contribute'">
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once 'includes/footer.php';
?>