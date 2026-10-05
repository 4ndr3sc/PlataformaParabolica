<style>
    .asotv-chatbot-button {
        position: fixed;
        right: 1.5rem;
        bottom: 1.5rem;
        z-index: 60;
        width: 3.75rem;
        height: 3.75rem;
        border: 0;
        border-radius: 9999px;
        background: #f59e0b;
        color: #172554;
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.28);
        cursor: pointer;
        transition: transform 180ms ease, background-color 180ms ease;
    }

    .asotv-chatbot-button:hover,
    .asotv-chatbot-button:focus-visible {
        background: #fbbf24;
        transform: translateY(-3px);
        outline: none;
    }

    .asotv-chatbot-panel {
        position: fixed;
        right: 1.5rem;
        bottom: 6.25rem;
        z-index: 60;
        display: none;
        flex-direction: column;
        width: min(32rem, calc(100vw - 2rem));
        height: min(42rem, calc(100vh - 7rem));
        min-height: 32rem;
        overflow: hidden;
        border: 1px solid #dbeafe;
        border-radius: 1rem;
        background: #fff;
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.24);
    }

    .asotv-chatbot-panel.is-open {
        display: flex;
        animation: asotv-chatbot-in 180ms ease-out;
    }

    .asotv-chatbot-messages {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        flex: 1;
        min-height: 0;
        overflow-y: auto;
        padding: 1.25rem;
        background: #f8fafc;
    }

    .asotv-chatbot-message {
        max-width: 88%;
        padding: 0.8rem 1rem;
        border-radius: 0.85rem;
        color: #334155;
        font-size: 1rem;
        line-height: 1.55;
    }

    .asotv-chatbot-message--bot {
        align-self: flex-start;
        background: #dbeafe;
        border-bottom-left-radius: 0.25rem;
    }

    .asotv-chatbot-message--user {
        align-self: flex-end;
        background: #1d4ed8;
        color: #fff;
        border-bottom-right-radius: 0.25rem;
    }

    .asotv-chatbot-options {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        padding: 1rem 1.25rem 1.1rem;
    }

    .asotv-chatbot-form {
        display: flex;
        gap: 0.5rem;
        padding: 0.9rem 1.25rem;
        border-top: 1px solid #e2e8f0;
        background: #fff;
    }

    .asotv-chatbot-input {
        min-width: 0;
        flex: 1;
        border: 1px solid #cbd5e1;
        border-radius: 0.65rem;
        padding: 0.8rem 0.9rem;
        color: #334155;
        font-size: 1rem;
    }

    .asotv-chatbot-input:focus {
        border-color: #2563eb;
        outline: 2px solid #bfdbfe;
    }

    .asotv-chatbot-send {
        width: 2.75rem;
        border: 0;
        border-radius: 0.65rem;
        background: #1d4ed8;
        color: #fff;
        cursor: pointer;
    }

    .asotv-chatbot-send:disabled {
        cursor: wait;
        opacity: 0.6;
    }

    .asotv-chatbot-typing {
        color: #64748b;
        font-size: 0.875rem;
        font-style: italic;
    }

    .asotv-chatbot-option {
        border: 1px solid #93c5fd;
        border-radius: 9999px;
        padding: 0.45rem 0.7rem;
        background: #fff;
        color: #1d4ed8;
        cursor: pointer;
        font-size: 0.75rem;
        font-weight: 700;
        transition: background-color 180ms ease, color 180ms ease;
    }

    .asotv-chatbot-option:hover,
    .asotv-chatbot-option:focus-visible {
        background: #1d4ed8;
        color: #fff;
        outline: none;
    }

    @keyframes asotv-chatbot-in {
        from { opacity: 0; transform: translateY(0.5rem); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 640px) {
        .asotv-chatbot-button { right: 1rem; bottom: 1rem; }
        .asotv-chatbot-panel {
            right: 0.75rem;
            bottom: 5.75rem;
            width: calc(100vw - 1.5rem);
            height: min(42rem, calc(100vh - 7rem));
            min-height: 28rem;
        }
    }
</style>

<div id="asotv-chatbot" class="asotv-chatbot-panel" role="dialog" aria-label="Chat de AsoTV" aria-hidden="true">
    <div class="flex items-center justify-between bg-blue-900 px-4 py-3 text-white">
        <div class="flex items-center gap-2">
            <i class="fas fa-robot text-yellow-400" aria-hidden="true"></i>
            <div>
                <p class="text-base font-bold">Asistente AsoTV</p>
                <p class="text-sm text-blue-200">Información sobre nuestros servicios</p>
            </div>
        </div>
        <button type="button" id="asotv-chatbot-close" class="text-blue-200 transition hover:text-white" aria-label="Cerrar chat">
            <i class="fas fa-times" aria-hidden="true"></i>
        </button>
    </div>

    <div id="asotv-chatbot-messages" class="asotv-chatbot-messages" aria-live="polite">
        <p class="asotv-chatbot-message asotv-chatbot-message--bot">¡Hola! Puedo ayudarte con información sobre televisión, internet y nuestros planes.</p>
    </div>

    <div class="asotv-chatbot-options">
        <button type="button" class="asotv-chatbot-option" data-question="planes">Ver planes</button>
        <button type="button" class="asotv-chatbot-option" data-question="television">Televisión</button>
        <button type="button" class="asotv-chatbot-option" data-question="internet">Internet</button>
        <button type="button" class="asotv-chatbot-option" data-question="contacto">Hablar con AsoTV</button>
    </div>

    <form id="asotv-chatbot-form" class="asotv-chatbot-form">
        <label for="asotv-chatbot-input" class="sr-only">Escribe tu duda</label>
        <input id="asotv-chatbot-input" class="asotv-chatbot-input" type="text" maxlength="1000" placeholder="Escribe tu duda..." autocomplete="off" required>
        <button type="submit" class="asotv-chatbot-send" aria-label="Enviar mensaje">
            <i class="fas fa-paper-plane" aria-hidden="true"></i>
        </button>
    </form>
</div>

<button type="button" id="asotv-chatbot-open" class="asotv-chatbot-button" aria-label="Abrir chat de AsoTV" aria-expanded="false" aria-controls="asotv-chatbot">
    <i class="fas fa-comments text-xl" aria-hidden="true"></i>
</button>

<script>
    (() => {
        const panel = document.getElementById('asotv-chatbot');
        const openButton = document.getElementById('asotv-chatbot-open');
        const closeButton = document.getElementById('asotv-chatbot-close');
        const messages = document.getElementById('asotv-chatbot-messages');
        const form = document.getElementById('asotv-chatbot-form');
        const input = document.getElementById('asotv-chatbot-input');
        const sendButton = form.querySelector('button[type="submit"]');
        const csrfToken = '{{ csrf_token() }}';
        const currentPage = @json(request()->path());
        const history = [];

        const setChatState = (isOpen) => {
            panel.classList.toggle('is-open', isOpen);
            panel.setAttribute('aria-hidden', String(!isOpen));
            openButton.setAttribute('aria-expanded', String(isOpen));
            if (isOpen) input.focus();
        };

        const addMessage = (content, type) => {
            const message = document.createElement('p');
            message.className = `asotv-chatbot-message asotv-chatbot-message--${type}`;
            if (type === 'bot') {
                const escapedContent = String(content)
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');

                message.innerHTML = escapedContent
                    .replace(/\*\*/g, '')
                    .replace(/__/g, '')
                    .replace(/`([^`]+)`/g, '<code>$1</code>')
                    .replace(/\n/g, '<br>');
            } else {
                message.textContent = content;
            }
            messages.appendChild(message);
            messages.scrollTop = messages.scrollHeight;
        };

        const askAssistant = async (question) => {
            addMessage(question, 'user');
            history.push({ role: 'user', content: question });
            input.value = '';
            input.disabled = true;
            sendButton.disabled = true;

            const typing = document.createElement('p');
            typing.className = 'asotv-chatbot-message asotv-chatbot-message--bot asotv-chatbot-typing';
            typing.textContent = 'Escribiendo...';
            messages.appendChild(typing);
            messages.scrollTop = messages.scrollHeight;

            try {
                const response = await fetch('{{ route('chatbot.reply') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        message: question,
                        page: currentPage,
                        history: history.slice(0, -1).slice(-10),
                    }),
                });
                const data = await response.json();
                typing.remove();
                addMessage(data.message || 'No pude responder en este momento.', 'bot');
                history.push({ role: 'assistant', content: data.message || 'No pude responder en este momento.' });
            } catch (error) {
                typing.remove();
                addMessage('No pude conectarme con el asistente. Intenta nuevamente.', 'bot');
            } finally {
                input.disabled = false;
                sendButton.disabled = false;
                input.focus();
            }
        };

        openButton.addEventListener('click', () => setChatState(!panel.classList.contains('is-open')));
        closeButton.addEventListener('click', () => setChatState(false));

        document.querySelectorAll('.asotv-chatbot-option').forEach((option) => {
            option.addEventListener('click', () => {
                askAssistant(option.textContent.trim());
            });
        });

        form.addEventListener('submit', (event) => {
            event.preventDefault();
            const question = input.value.trim();
            if (question && !input.disabled) askAssistant(question);
        });
    })();
</script>