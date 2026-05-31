<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('API Documentation') }}
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Base URL</h3>
            <code class="bg-gray-100 px-3 py-1 rounded text-sm text-gray-700">{{ config('app.url') }}/api</code>
        </div>

        <!-- Endpoint 1: Get All Clients -->
        <div class="bg-white rounded-lg shadow-md mb-6 overflow-hidden">
            <div class="flex items-center bg-green-50 border-l-4 border-green-500 px-6 py-4">
                <span class="bg-green-500 text-white font-bold px-3 py-1 rounded text-sm mr-4">GET</span>
                <h4 class="font-semibold text-lg text-gray-800">/clients</h4>
            </div>
            <div class="p-6">
                <p class="text-gray-700 mb-4">Get list of all clients</p>
                
                <h5 class="font-semibold text-gray-800 mb-2">Response</h5>
                <pre class="bg-gray-50 border rounded p-4 text-sm overflow-x-auto"><code class="text-gray-700">[
    {
        "id": 1,
        "username": "client1",
        "name": "Client One",
        "address": "123 Street",
        "phone": "0123456789",
        "keyword_count": 100,
        "remaining_keywords": 95,
        "is_enabled": true,
        "created_at": "2024-01-01T00:00:00Z",
        "updated_at": "2024-01-01T00:00:00Z"
    }
]</code></pre>
            </div>
        </div>

        <!-- Endpoint 2: Get Single Client -->
        <div class="bg-white rounded-lg shadow-md mb-6 overflow-hidden">
            <div class="flex items-center bg-green-50 border-l-4 border-green-500 px-6 py-4">
                <span class="bg-green-500 text-white font-bold px-3 py-1 rounded text-sm mr-4">GET</span>
                <h4 class="font-semibold text-lg text-gray-800">/clients/{client}</h4>
            </div>
            <div class="p-6">
                <p class="text-gray-700 mb-4">Get a single client by ID</p>
                
                <h5 class="font-semibold text-gray-800 mb-2">Parameters</h5>
                <ul class="list-disc list-inside text-gray-700 mb-4">
                    <li><code class="bg-gray-100 px-1 rounded">client</code> - Client ID (integer)</li>
                </ul>

                <h5 class="font-semibold text-gray-800 mb-2">Response</h5>
                <pre class="bg-gray-50 border rounded p-4 text-sm overflow-x-auto"><code class="text-gray-700">{
    "id": 1,
    "username": "client1",
    "name": "Client One",
    "address": "123 Street",
    "phone": "0123456789",
    "keyword_count": 100,
    "remaining_keywords": 95,
    "is_enabled": true,
    "created_at": "2024-01-01T00:00:00Z",
    "updated_at": "2024-01-01T00:00:00Z"
}</code></pre>
            </div>
        </div>

        <!-- Endpoint 3: Update Keywords -->
        <div class="bg-white rounded-lg shadow-md mb-6 overflow-hidden">
            <div class="flex items-center bg-blue-50 border-l-4 border-blue-500 px-6 py-4">
                <span class="bg-blue-500 text-white font-bold px-3 py-1 rounded text-sm mr-4">POST</span>
                <h4 class="font-semibold text-lg text-gray-800">/clients/{client}/use-keywords</h4>
            </div>
            <div class="p-6">
                <p class="text-gray-700 mb-4">Decrement client's remaining keywords</p>
                
                <h5 class="font-semibold text-gray-800 mb-2">Parameters</h5>
                <ul class="list-disc list-inside text-gray-700 mb-4">
                    <li><code class="bg-gray-100 px-1 rounded">client</code> - Client ID (integer)</li>
                </ul>

                <h5 class="font-semibold text-gray-800 mb-2">Request Body</h5>
                <pre class="bg-gray-50 border rounded p-4 text-sm overflow-x-auto mb-4"><code class="text-gray-700">{
    "keywords_used": 1
}</code></pre>

                <h5 class="font-semibold text-gray-800 mb-2">Response</h5>
                <pre class="bg-gray-50 border rounded p-4 text-sm overflow-x-auto"><code class="text-gray-700">{
    "message": "Keywords updated",
    "remaining_keywords": 94
}</code></pre>
            </div>
        </div>

        <!-- Endpoint 4: Extract Invoice -->
        <div class="bg-white rounded-lg shadow-md mb-6 overflow-hidden">
            <div class="flex items-center bg-blue-50 border-l-4 border-blue-500 px-6 py-4">
                <span class="bg-blue-500 text-white font-bold px-3 py-1 rounded text-sm mr-4">POST</span>
                <h4 class="font-semibold text-lg text-gray-800">/extract-invoice</h4>
            </div>
            <div class="p-6">
                <p class="text-gray-700 mb-4">Extract data from invoice image using AI</p>
                
                <h5 class="font-semibold text-gray-800 mb-2">Request Body</h5>
                <pre class="bg-gray-50 border rounded p-4 text-sm overflow-x-auto mb-4"><code class="text-gray-700">{
    "username": "client_username",
    "password": "client_password",
    "serial_number": "unique_serial_number",
    "image": "base64_encoded_image OR file upload"
}</code></pre>

                <h5 class="font-semibold text-gray-800 mb-2">Response (Success)</h5>
                <pre class="bg-gray-50 border rounded p-4 text-sm overflow-x-auto mb-4"><code class="text-gray-700">{
    "username": "client_username",
    "serial_number": "unique_serial_number",
    "remaining_quota": 94,
    "invoice_data": {
        "invoice_number": "INV-001",
        "date": "2024-01-01",
        "total": 100.00
    }
}</code></pre>

                <h5 class="font-semibold text-gray-800 mb-2">Response (Error)</h5>
                <pre class="bg-gray-50 border rounded p-4 text-sm overflow-x-auto"><code class="text-gray-700">{
    "error": "Error message description"
}</code></pre>
            </div>
        </div>
    </div>
</x-app-layout>
