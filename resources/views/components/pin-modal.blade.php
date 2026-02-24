<!-- Modal para ver detalles del pin y comentarios -->
<div id="pinModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-h-[90vh] overflow-hidden flex w-full max-w-5xl shadow-2xl">
        
        <!-- Imagen del Pin (60%) -->
        <div class="hidden md:flex md:w-3/5 bg-gray-100 items-center justify-center overflow-auto relative group">
            <img id="pinImage" src="" alt="Pin" class="w-full h-full object-contain">
            
            <!-- Botones de acción sobre la imagen -->
            <div class="absolute top-4 right-4 flex gap-2 opacity-0 group-hover:opacity-100 transition">
                <button 
                    onclick="toggleLike()"
                    id="likeBtn"
                    class="bg-white hover:bg-gray-100 text-gray-900 rounded-full p-3 shadow-lg transition"
                    title="Me gusta"
                >
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"></path>
                    </svg>
                </button>
                <button 
                    onclick="downloadPin()"
                    class="bg-white hover:bg-gray-100 text-gray-900 rounded-full p-3 shadow-lg transition"
                    title="Descargar"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Detalles y Comentarios (40%) -->
        <div class="w-full md:w-2/5 flex flex-col bg-white">
            
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <h2 id="pinTitle" class="text-xl font-bold truncate"></h2>
                <button onclick="closePinModal()" class="text-gray-500 hover:bg-gray-100 p-2 rounded-full flex-shrink-0 ml-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Descripción y Info del Usuario -->
            <div class="px-6 py-4 border-b">
                <p id="pinDescription" class="text-gray-700 mb-4 text-sm leading-relaxed"></p>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-red-400 to-red-600 rounded-full flex items-center justify-center font-bold text-white text-sm flex-shrink-0">
                            <span id="userInitial">U</span>
                        </div>
                        <div>
                            <a id="userProfileLink" href="#" class="font-semibold text-sm text-gray-900 hover:text-red-600 transition">Usuario</a>
                            <p id="pinDate" class="text-xs text-gray-500">hace poco</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-1">
                        <button id="followBtn" onclick="toggleFollow()" class="bg-red-600 hover:bg-red-700 text-white rounded-full px-6 py-2 font-semibold text-sm transition">
                            Seguir
                        </button>
                        <p id="followersCountText" class="text-xs text-gray-500 leading-none">0 seguidores</p>
                    </div>
                </div>
            </div>

            <!-- Acciones (Likes, Comentarios) -->
            <div class="px-6 py-3 border-b flex items-center gap-4">
                <button 
                    onclick="toggleLike()"
                    id="likeBtnMobile"
                    class="flex items-center gap-1 text-gray-700 hover:text-red-600 transition"
                >
                    <svg id="likeBtnIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 20 20">
                        <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"></path>
                    </svg>
                    <span id="likesCount" class="text-sm font-semibold">0</span>
                </button>
                <button 
                    onclick="downloadPin()"
                    class="flex items-center gap-1 text-gray-700 hover:text-red-600 transition"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    <span class="text-sm">Descargar</span>
                </button>
                <button 
                    onclick="reportPin()"
                    class="flex items-center gap-1 text-gray-700 hover:text-amber-600 transition"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v12l-2 4m0 0h10l-2-4m-6 0h6M13 3v12"></path>
                    </svg>
                    <span class="text-sm">Reportar</span>
                </button>
                <button 
                    id="deletePinBtn"
                    onclick="deletePin(currentPinId, document.getElementById('pinTitle').textContent || 'Pin')"
                    class="hidden flex items-center gap-1 text-red-600 hover:text-red-700 transition"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    <span class="text-sm">Eliminar</span>
                </button>
            </div>

            <!-- Comentarios -->
            <div class="flex-1 overflow-y-auto px-6 py-4 space-y-4">
                <h3 class="text-gray-900 font-semibold text-sm">Comentarios</h3>
                <div id="commentsList" class="space-y-4">
                    <!-- Los comentarios se cargarán aquí -->
                </div>
            </div>

            <!-- Formulario para agregar comentario -->
            <div id="commentFormContainer" class="border-t px-6 py-4 bg-gray-50">
                <form id="commentForm" onsubmit="submitComment(event)" class="flex gap-2">
                    <input 
                        type="text" 
                        id="commentInput"
                        placeholder="Añade un comentario..."
                        class="flex-1 border border-gray-300 rounded-full px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500"
                        required
                    >
                    <button 
                        type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white rounded-full px-6 py-2 font-semibold text-sm transition"
                    >
                        Enviar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para reportar pin -->
<div id="reportModal" class="hidden fixed inset-0 bg-black bg-opacity-60 z-[120] flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl p-6 space-y-4 relative z-[121]">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">Denunciar Pin</h3>
            <button onclick="closeReportModal()" class="text-gray-500 hover:bg-gray-100 p-2 rounded-full">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <p class="text-sm text-gray-600">Selecciona el motivo que mejor describa el problema.</p>

        <div class="space-y-3">
            ${''}
            <label class="flex items-start gap-3 cursor-pointer text-sm text-gray-800">
                <input type="radio" name="report-reason" value="Correo no deseado" class="mt-1" />
                <span>
                    <span class="font-semibold">Correo no deseado</span>
                    <div class="text-xs text-gray-500">Publicaciones engañosas o repetitivas</div>
                </span>
            </label>
            <label class="flex items-start gap-3 cursor-pointer text-sm text-gray-800">
                <input type="radio" name="report-reason" value="Desnudez o contenido sexualizado" class="mt-1" />
                <span>
                    <span class="font-semibold">Desnudez, pornografía o contenido sexualizado</span>
                    <div class="text-xs text-gray-500">Contenido sexualmente explícito que incluye adultos o desnudez; no denunciar contenido educativo de menores</div>
                </span>
            </label>
            <label class="flex items-start gap-3 cursor-pointer text-sm text-gray-800">
                <input type="radio" name="report-reason" value="Autolesiones" class="mt-1" />
                <span>
                    <span class="font-semibold">Autolesiones</span>
                    <div class="text-xs text-gray-500">Trastornos de la alimentación, autolesiones o suicidio</div>
                </span>
            </label>
            <label class="flex items-start gap-3 cursor-pointer text-sm text-gray-800">
                <input type="radio" name="report-reason" value="Información falsa" class="mt-1" />
                <span>
                    <span class="font-semibold">Información falsa</span>
                    <div class="text-xs text-gray-500">Información errónea o conspiraciones relativas a la salud, el clima o las elecciones</div>
                </span>
            </label>
            <label class="flex items-start gap-3 cursor-pointer text-sm text-gray-800">
                <input type="radio" name="report-reason" value="Odio" class="mt-1" />
                <span>
                    <span class="font-semibold">Actividades que incitan al odio</span>
                    <div class="text-xs text-gray-500">Prejuicios, estereotipos, supremacía blanca, calumnias</div>
                </span>
            </label>
            <label class="flex items-start gap-3 cursor-pointer text-sm text-gray-800">
                <input type="radio" name="report-reason" value="Mercancías peligrosas" class="mt-1" />
                <span>
                    <span class="font-semibold">Mercancías peligrosas</span>
                    <div class="text-xs text-gray-500">Drogas, armas, productos ilegales</div>
                </span>
            </label>
            <label class="flex items-start gap-3 cursor-pointer text-sm text-gray-800">
                <input type="radio" name="report-reason" value="Acoso o críticas" class="mt-1" />
                <span>
                    <span class="font-semibold">Acoso o críticas</span>
                    <div class="text-xs text-gray-500">Insultos, amenazas, doxxeo, imágenes de desnudos no consentidas</div>
                </span>
            </label>
            <label class="flex items-start gap-3 cursor-pointer text-sm text-gray-800">
                <input type="radio" name="report-reason" value="Violencia gráfica" class="mt-1" />
                <span>
                    <span class="font-semibold">Violencia gráfica</span>
                    <div class="text-xs text-gray-500">Imágenes o videos de violencia o daño físico</div>
                </span>
            </label>
            <label class="flex items-start gap-3 cursor-pointer text-sm text-gray-800">
                <input type="radio" name="report-reason" value="Infracción de privacidad" class="mt-1" />
                <span>
                    <span class="font-semibold">Infracción de privacidad</span>
                    <div class="text-xs text-gray-500">Información personal publicada sin permiso</div>
                </span>
            </label>
            <label class="flex items-start gap-3 cursor-pointer text-sm text-gray-800">
                <input type="radio" name="report-reason" value="Mi propiedad intelectual" class="mt-1" />
                <span>
                    <span class="font-semibold">Mi propiedad intelectual</span>
                    <div class="text-xs text-gray-500">Derechos de autor o marca registrada</div>
                </span>
            </label>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <button onclick="closeReportModal()" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-full">Cancelar</button>
            <button onclick="submitReport()" id="reportSubmitBtn" class="px-5 py-2 text-sm rounded-full bg-amber-600 text-white hover:bg-amber-700 transition">Enviar</button>
        </div>
    </div>
</div>

<!-- Imagen responsiva en móvil -->
<div id="pinImageMobile" class="md:hidden fixed top-0 left-0 right-0 z-40 bg-black">
    <img id="pinImageMobileImg" src="" alt="Pin" class="w-full h-screen object-contain">
</div>

<script>
    let currentPinId = null;
    let pinAllowsComments = true;
    let reportSubmitting = false;
    let currentAuthorId = null;
    let currentAuthorIsSelf = false;
    let currentAuthorIsFollowing = false;

    // Renderizar comentarios y respuestas en forma recursiva
    function renderComments(comments = [], level = 0) {
        if (!comments.length) return '';

        return comments.map(comment => {
            const indent = level > 0 ? 'ml-10 border-l border-gray-200 pl-4' : '';
            const canReply = pinAllowsComments; // ahora todos los usuarios autenticados pueden responder
            return `
                <div class="flex gap-3 pb-4 border-b last:border-b-0 ${indent}">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center font-bold text-xs text-white flex-shrink-0">
                        ${comment.user_initial}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <p class="font-semibold text-sm text-gray-900">${comment.user_name}</p>
                            <p class="text-xs text-gray-500">${comment.created_at}</p>
                        </div>
                        <p class="text-gray-700 text-sm break-words">${comment.content}</p>
                        <div class="flex items-center gap-3 mt-2">
                            ${comment.is_owner ? `
                                <button onclick="deleteComment(${comment.id}, event)" class="text-xs text-red-600 hover:underline font-semibold">
                                    Eliminar
                                </button>
                            ` : ''}
                            ${canReply ? `
                                <button onclick="toggleReplyForm(${comment.id})" class="text-xs text-blue-600 hover:underline font-semibold">
                                    Responder
                                </button>
                            ` : ''}
                        </div>
                        <div id="reply-form-${comment.id}" class="hidden mt-3">
                            <form onsubmit="submitReply(event, ${comment.id})" class="flex gap-2 items-center">
                                <input 
                                    type="text" 
                                    id="replyInput-${comment.id}"
                                    placeholder="Escribe tu respuesta..."
                                    class="flex-1 border border-gray-300 rounded-full px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500"
                                    required
                                >
                                <button 
                                    type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white rounded-full px-4 py-2 font-semibold text-xs transition"
                                >
                                    Responder
                                </button>
                            </form>
                        </div>
                        ${comment.replies && comment.replies.length ? `<div class="mt-3 space-y-3">${renderComments(comment.replies, level + 1)}</div>` : ''}
                    </div>
                </div>
            `;
        }).join('');
    }

    function formatFollowers(count = 0) {
        const n = Number(count) || 0;
        return n === 1 ? '1 seguidor' : `${n} seguidores`;
    }

    function updateFollowButton(isFollowing, isSelf = false) {
        const btn = document.getElementById('followBtn');
        if (!btn) return;

        btn.dataset.state = isFollowing ? 'following' : 'not-following';
        btn.dataset.self = isSelf ? '1' : '0';

        if (isSelf) {
            btn.textContent = 'Tú';
            btn.disabled = true;
            btn.className = 'bg-gray-200 text-gray-500 rounded-full px-6 py-2 font-semibold text-sm transition cursor-not-allowed';
            return;
        }

        btn.disabled = false;
        if (isFollowing) {
            btn.textContent = 'Siguiendo';
            btn.className = 'bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-full px-6 py-2 font-semibold text-sm transition border border-gray-300';
        } else {
            btn.textContent = 'Seguir';
            btn.className = 'bg-red-600 hover:bg-red-700 text-white rounded-full px-6 py-2 font-semibold text-sm transition';
        }
    }

    function updateDeletePinButton(canDelete) {
        const btn = document.getElementById('deletePinBtn');
        if (!btn) return;

        if (canDelete) {
            btn.classList.remove('hidden');
        } else {
            btn.classList.add('hidden');
        }
    }

    // Abrir modal con detalles del pin
    function openPinModal(pinId) {
        currentPinId = pinId;
        document.getElementById('pinModal').classList.remove('hidden');
        updateDeletePinButton(false);
        
        // Cargar datos del pin y comentarios
        fetch('/pins/' + pinId + '/detail')
            .then(response => response.json())
            .then(data => {
                const pin = data.pin;
                const comments = data.comments;
                pinAllowsComments = !!pin.allow_comments;

                // Llenar los datos del pin
                document.getElementById('pinImage').src = pin.image_url;
                document.getElementById('pinImageMobileImg').src = pin.image_url;
                document.getElementById('pinTitle').textContent = pin.title || 'Sin título';
                document.getElementById('pinDescription').textContent = pin.description || 'Sin descripción';
                document.getElementById('userInitial').textContent = pin.user_initial;
                const profileLink = document.getElementById('userProfileLink');
                if (profileLink) {
                    profileLink.textContent = pin.user_name || 'Usuario';
                    profileLink.href = '/usuarios/' + pin.user_id;
                }
                document.getElementById('pinDate').textContent = pin.created_at;
                currentAuthorId = pin.user_id;
                currentAuthorIsSelf = !!pin.is_self;
                currentAuthorIsFollowing = !!pin.is_following_author;
                updateFollowButton(currentAuthorIsFollowing, currentAuthorIsSelf);
                updateDeletePinButton(currentAuthorIsSelf);
                const followersText = document.getElementById('followersCountText');
                if (followersText) {
                    followersText.textContent = formatFollowers(pin.followers_count || 0);
                }
                
                // Actualizar likes
                document.getElementById('likesCount').textContent = pin.likes_count;
                updateLikeButton(pin.user_liked);

                // Cargar comentarios
                const commentsList = document.getElementById('commentsList');
                if (!comments || comments.length === 0) {
                    commentsList.innerHTML = '<p class="text-gray-500 text-sm text-center py-6">Sin comentarios aún. ¡Sé el primero!</p>';
                } else {
                    commentsList.innerHTML = renderComments(comments);
                }

                // Mostrar/ocultar formulario según si permite comentarios
                const commentFormContainer = document.getElementById('commentFormContainer');
                if (!pin.allow_comments) {
                    commentFormContainer.innerHTML = '<p class="text-gray-500 text-center text-sm py-4">Los comentarios están deshabilitados.</p>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('commentsList').innerHTML = '<p class="text-red-600 text-sm">Error al cargar comentarios</p>';
            });
    }

    // Cerrar modal
    function closePinModal() {
        document.getElementById('pinModal').classList.add('hidden');
        currentPinId = null;
    }

    // Enviar comentario
    function submitComment(event) {
        event.preventDefault();
        if (!currentPinId) return;

        const content = document.getElementById('commentInput').value.trim();
        if (!content) return;

        const button = event.target.querySelector('button[type="submit"]');
        button.disabled = true;
        button.textContent = 'Enviando...';

        fetch('/pins/' + currentPinId + '/comments', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({ content: content })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('commentInput').value = '';
                // Recargar comentarios
                openPinModal(currentPinId);
            } else {
                alert(data.message || 'Error al publicar comentario');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al publicar comentario');
        })
        .finally(() => {
            button.disabled = false;
            button.textContent = 'Enviar';
        });
    }

    // Eliminar comentario
    function deleteComment(commentId, event) {
        event.preventDefault();
        if (!confirm('¿Estás seguro de que quieres eliminar este comentario?')) return;

        fetch('/comments/' + commentId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Recargar comentarios
                openPinModal(currentPinId);
            } else {
                alert(data.message || 'Error al eliminar comentario');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al eliminar comentario');
        });
    }

    // Mostrar u ocultar formulario de respuesta
    function toggleReplyForm(commentId) {
        const form = document.getElementById('reply-form-' + commentId);
        if (!form) return;
        form.classList.toggle('hidden');
        if (!form.classList.contains('hidden')) {
            const input = document.getElementById('replyInput-' + commentId);
            input?.focus();
        }
    }

    // Enviar respuesta (solo dueño del pin)
    function submitReply(event, parentId) {
        event.preventDefault();
        if (!currentPinId) return;

        const input = document.getElementById('replyInput-' + parentId);
        if (!input) return;

        const content = input.value.trim();
        if (!content) return;

        const button = event.target.querySelector('button[type="submit"]');
        if (button) {
            button.disabled = true;
            button.textContent = 'Enviando...';
        }

        fetch('/pins/' + currentPinId + '/comments', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({ content: content, parent_id: parentId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                input.value = '';
                toggleReplyForm(parentId);
                openPinModal(currentPinId);
            } else {
                alert(data.message || 'Error al responder comentario');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al responder comentario');
        })
        .finally(() => {
            if (button) {
                button.disabled = false;
                button.textContent = 'Responder';
            }
        });
    }

    // Cerrar modal al hacer clic fuera
    document.getElementById('pinModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closePinModal();
        }
    });

    // Cerrar con tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !document.getElementById('pinModal').classList.contains('hidden')) {
            closePinModal();
        }
    });

    // Eliminar pin
    function deletePin(pinId, pinTitle) {
        if (!confirm('¿Estás seguro de que quieres eliminar "' + pinTitle + '"?')) return;

        fetch('/pins/' + pinId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Pin eliminado correctamente');
                // Recargar la página para actualizar la lista
                location.reload();
            } else {
                alert(data.message || 'Error al eliminar el pin');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al eliminar el pin');
        });
    }

    // Alternar like
    function toggleLike() {
        if (!currentPinId) return;

        fetch('/pins/' + currentPinId + '/like', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success || data.message === 'Like agregado.') {
                // Cambiar a quitar like
                document.getElementById('likesCount').textContent = data.likes_count;
                updateLikeButton(true);
            } else if (data.message === 'Ya has dado like a este pin.') {
                // Ya tiene like, mostrar opción de quitar
                removeLike();
            } else if (data.message.includes('401')) {
                window.location.href = '{{ route("login") }}';
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    // Remover like
    function removeLike() {
        if (!currentPinId) return;

        fetch('/pins/' + currentPinId + '/like', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('likesCount').textContent = data.likes_count;
                updateLikeButton(false);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function toggleFollow() {
        if (!currentAuthorId) return;

        const btn = document.getElementById('followBtn');
        if (!btn) return;
        if (btn.dataset.self === '1') return;

        const isFollowing = btn.dataset.state === 'following';
        const method = isFollowing ? 'DELETE' : 'POST';
        let statusCode = 0;

        fetch('/users/' + currentAuthorId + '/follow', {
            method: method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            statusCode = response.status;
            return response.json();
        })
        .then(data => {
            if (statusCode === 401) {
                window.location.href = '{{ route("login") }}';
                return;
            }

            if (!data.success) {
                alert(data.message || 'No se pudo completar la acción.');
                return;
            }

            currentAuthorIsFollowing = !!data.following;
            updateFollowButton(currentAuthorIsFollowing, false);

            const followersText = document.getElementById('followersCountText');
            if (followersText) {
                followersText.textContent = formatFollowers(data.followers_count || 0);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    // Reportar pin
    function reportPin() {
        if (!currentPinId) return;
        document.getElementById('reportModal')?.classList.remove('hidden');
        // limpiar selección previa
        document.querySelectorAll('input[name="report-reason"]').forEach(r => r.checked = false);
    }

    function closeReportModal() {
        document.getElementById('reportModal')?.classList.add('hidden');
    }

    function submitReport() {
        if (!currentPinId || reportSubmitting) return;
        const selected = Array.from(document.querySelectorAll('input[name="report-reason"]')).find(r => r.checked);
        if (!selected) {
            alert('Selecciona un motivo para continuar.');
            return;
        }

        reportSubmitting = true;
        const btn = document.getElementById('reportSubmitBtn');
        if (btn) {
            btn.disabled = true;
            btn.textContent = 'Enviando...';
        }

        let statusCode = 0;
        fetch('/pins/' + currentPinId + '/report', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({ reason: selected.value })
        })
        .then(response => {
            statusCode = response.status;
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert(data.message || 'Reporte enviado.');
                closeReportModal();
            } else {
                if (statusCode === 401) {
                    window.location.href = '{{ route("login") }}';
                    return;
                }
                alert(data.message || 'No se pudo enviar el reporte.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al enviar el reporte.');
        })
        .finally(() => {
            reportSubmitting = false;
            if (btn) {
                btn.disabled = false;
                btn.textContent = 'Enviar';
            }
        });
    }

    // Actualizar estado del botón de like
    function updateLikeButton(isLiked) {
        const likeBtn = document.getElementById('likeBtn');
        const likeBtnIcon = document.getElementById('likeBtnIcon');
        
        if (isLiked) {
            if (likeBtn) {
                likeBtn.classList.remove('hover:bg-gray-100');
                likeBtn.classList.add('bg-red-100', 'hover:bg-red-200', 'text-red-600');
            }
            if (likeBtnIcon) {
                likeBtnIcon.setAttribute('fill', 'currentColor');
            }
        } else {
            if (likeBtn) {
                likeBtn.classList.remove('bg-red-100', 'hover:bg-red-200', 'text-red-600');
                likeBtn.classList.add('hover:bg-gray-100');
            }
            if (likeBtnIcon) {
                likeBtnIcon.setAttribute('fill', 'none');
            }
        }
    }

    // Descargar pin
    function downloadPin() {
        const imageUrl = document.getElementById('pinImage').src;
        const link = document.createElement('a');
        link.href = imageUrl;
        link.download = 'pin-' + currentPinId + '.jpg';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>
