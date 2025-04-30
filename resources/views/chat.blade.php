<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mohospital Chat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-4 max-w-3xl">
        <h1 class="text-2xl font-bold text-blue-800 mb-6">Mohospital Patient Support</h1>

        <div class="bg-white rounded-lg shadow-md p-4 mb-4 h-96 overflow-y-auto" id="chat-container">
            <div class="chat-message bg-blue-50 p-3 rounded mb-2">
                <strong>Assistant:</strong> Hello! I'm your Mohospital assistant. How can I help you today?
            </div>
        </div>

        <form id="chat-form" class="flex gap-2">
            <input type="text" id="message-input" class="flex-1 p-2 border border-gray-300 rounded"
                placeholder="Type your message..." required>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Send
            </button>
        </form>
    </div>

    <script>
        document.getElementById('chat-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            const input = document.getElementById('message-input');
            const message = input.value.trim();
            const chatContainer = document.getElementById('chat-container');

            if (!message) return;

            // Add user message to chat
            chatContainer.innerHTML += `
                <div class="chat-message bg-gray-100 p-3 rounded mb-2 text-right">
                    <strong>You:</strong> ${message}
                </div>
            `;

            // Clear input
            input.value = '';

            // Get conversation history
            const history = Array.from(document.querySelectorAll('.chat-message')).map(msg => {
                const isUser = msg.classList.contains('text-right');
                return {
                    role: isUser ? 'user' : 'assistant',
                    content: msg.textContent.replace(/^(You|Assistant):\s*/i, '')
                };
            }).slice(1); // Skip the initial greeting

            try {
                const response = await fetch('/api/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        message: message,
                        history: history
                    })
                });

                const data = await response.json();

                if (data.error) {
                    throw new Error(data.error);
                }

                // Add assistant response to chat
                chatContainer.innerHTML += `
                    <div class="chat-message bg-blue-50 p-3 rounded mb-2">
                        <strong>Assistant:</strong> ${data.response}
                    </div>
                `;

                // Scroll to bottom
                chatContainer.scrollTop = chatContainer.scrollHeight;

            } catch (error) {
                console.error('Error:', error);
                chatContainer.innerHTML += `
                    <div class="chat-message bg-red-50 p-3 rounded mb-2 text-red-600">
                        <strong>Error:</strong> Failed to get response. Please try again.
                    </div>
                `;
            }
        });
    </script>
</body>

</html>
