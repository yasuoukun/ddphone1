@if(auth()->check() && auth()->user()->role === 'customer')
<div x-data="chatWidget()" x-init="initChat()" @open-customer-chat.window="open = true; fetchMessages(); scrollDown();" style="position: fixed; bottom: 25px; right: 25px; z-index: 9999999; font-family: 'Prompt', sans-serif;">
     
    <!-- Chat Window -->
    <div x-show="open" x-cloak
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-y-10 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-10 scale-95"
         style="width: 360px; height: 520px; max-height: calc(100vh - 120px); background: #fff; border-radius: 20px; box-shadow: 0 15px 40px rgba(27, 42, 71, 0.2); margin-bottom: 16px; overflow: hidden; border: 1px solid rgba(27, 42, 71, 0.08); position: relative;">
        
        <!-- Header -->
        <div style="position: absolute; top: 0; left: 0; right: 0; height: 72px; box-sizing: border-box; background: linear-gradient(135deg, #1B2A47 0%, #2A3E5C 100%); color: white; padding: 16px 20px; display: flex; justify-content: space-between; align-items: center; z-index: 10;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="position: relative; width: 40px; height: 40px; background: rgba(255, 255, 255, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                    🧑‍💼
                    <span style="position: absolute; bottom: 1px; right: 1px; width: 10px; height: 10px; background: #10B981; border: 2px solid #1B2A47; border-radius: 50%;"></span>
                </div>
                <div>
                    <div style="font-weight: 700; font-size: 0.95rem; line-height: 1.2;">ฝ่ายบริการลูกค้า</div>
                    <div style="font-size: 0.72rem; color: rgba(255,255,255,0.7); display: flex; align-items: center; gap: 4px;">
                        <span style="display: inline-block; width: 6px; height: 6px; background: #10B981; border-radius: 50%;"></span>
                        ออนไลน์พร้อมช่วยเหลือ
                    </div>
                </div>
            </div>
            <button @click="open = false" style="background: rgba(255,255,255,0.15); border: none; color: white; cursor: pointer; font-size: 1.1rem; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.15)'">&times;</button>
        </div>
        
        <!-- Messages Area -->
        <div id="chat-widget-messages" style="position: absolute; top: 72px; bottom: 64px; left: 0; right: 0; padding: 16px; overflow-y: auto; background: #F8FAFC; z-index: 1;">
            <div style="text-align: center; margin-bottom: 14px;">
                <span style="background: rgba(27, 42, 71, 0.05); color: #64748B; font-size: 0.72rem; padding: 4px 12px; border-radius: 12px; font-weight: 500;">
                    เริ่มต้นการสนทนา
                </span>
            </div>
            
            <template x-for="msg in messages" :key="msg.id">
                <div :style="msg.sender_id == userId ? 'width: 100%; display: flex; flex-direction: column; align-items: flex-end; margin-bottom: 10px;' : 'width: 100%; display: flex; flex-direction: column; align-items: flex-start; margin-bottom: 10px;'">
                    <div :style="msg.sender_id == userId 
                        ? 'background: #0084FF; color: #ffffff; border-radius: 18px 18px 4px 18px; box-shadow: 0 2px 6px rgba(0, 132, 255, 0.25);' 
                        : 'background: #E4E6EB; color: #050505; border-radius: 18px 18px 18px 4px; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);'" 
                          style="padding: 12px 18px; font-size: 0.95rem; line-height: 1.5; font-weight: 500; width: max-content; max-width: 80%; min-width: 32px; word-break: break-word; overflow-wrap: break-word; text-align: left; box-sizing: border-box;">
                        
                        <!-- Media Attachments -->
                        <template x-if="msg.attachment_path">
                            <div style="margin-bottom: 6px;">
                                <template x-if="msg.attachment_type === 'image'">
                                    <a :href="'/storage/' + msg.attachment_path" target="_blank">
                                        <img :src="'/storage/' + msg.attachment_path" style="max-width: 100%; max-height: 180px; border-radius: 12px; display: block; object-fit: cover;">
                                    </a>
                                </template>
                                <template x-if="msg.attachment_type === 'video'">
                                    <video :src="'/storage/' + msg.attachment_path" controls style="max-width: 100%; max-height: 180px; border-radius: 12px; display: block;"></video>
                                </template>
                                <template x-if="msg.attachment_type === 'file'">
                                    <a :href="'/storage/' + msg.attachment_path" target="_blank" style="color: inherit; font-weight: 600; text-decoration: underline;">📎 ดาวน์โหลดไฟล์แนบ</a>
                                </template>
                            </div>
                        </template>

                        <span x-show="msg.content" x-text="msg.content"></span>
                    </div>
                    <div :style="msg.sender_id == userId ? 'text-align: right;' : 'text-align: left;'" 
                         style="font-size: 0.68rem; color: #8A8D91; padding: 2px 6px 0; font-weight: 400;">
                        <span x-text="new Date(msg.created_at).toLocaleTimeString('th-TH', { hour: '2-digit', minute: '2-digit' })"></span>
                    </div>
                </div>
            </template>
        </div>

        <!-- Emoji Picker Popover -->
        <div x-show="showEmojis" @click.away="showEmojis = false" x-cloak style="position: absolute; bottom: 68px; left: 16px; right: 16px; background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 8px 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); display: flex; gap: 8px; flex-wrap: wrap; z-index: 20;">
            <template x-for="emoji in ['😊', '👍', '🔥', '📱', '📦', '💻', '🙏', '❤️', '✅', '⚡']">
                <button type="button" @click="newMessage += emoji; showEmojis = false" style="font-size: 1.3rem; background: none; border: none; cursor: pointer; padding: 4px; border-radius: 6px;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='none'" x-text="emoji"></button>
            </template>
        </div>
        
        <!-- Input Area -->
        <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 64px; box-sizing: border-box; padding: 12px 12px; border-top: 1px solid #e2e8f0; background: white; display: flex; gap: 6px; align-items: center; z-index: 10;">
            <!-- File Upload Button -->
            <input type="file" id="chat-file-input" @change="handleFileUpload($event)" accept="image/*,video/*" style="display: none;">
            <button type="button" @click="document.getElementById('chat-file-input').click()" style="background: #f1f5f9; color: #475569; border: none; border-radius: 50%; width: 36px; height: 36px; cursor: pointer; display: flex; align-items: center; justify-content: center;" title="แนบรูป/วิดีโอ">
                📷
            </button>

            <!-- Emoji Toggle Button -->
            <button type="button" @click="showEmojis = !showEmojis" style="background: #f1f5f9; color: #475569; border: none; border-radius: 50%; width: 36px; height: 36px; cursor: pointer; display: flex; align-items: center; justify-content: center;" title="ใส่อิโมจิ">
                😀
            </button>

            <input type="text" x-model="newMessage" 
                   @keydown.enter="sendMessage()"
                   placeholder="พิมพ์ข้อความ..." 
                   style="flex: 1; padding: 8px 12px; border: 1.5px solid #e2e8f0; border-radius: 20px; outline: none; font-size: 0.85rem; font-family: 'Prompt', sans-serif; transition: all 0.2s; background: #F8FAFC;"
                   onfocus="this.style.borderColor='#1B2A47'; this.style.background='white';"
                   onblur="this.style.borderColor='#e2e8f0'; this.style.background='#F8FAFC';">
            
            <button @click="sendMessage()" 
                    style="background: linear-gradient(135deg, #1B2A47, #2A3E5C); color: white; border: none; border-radius: 50%; width: 36px; height: 36px; min-width: 36px; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(27,42,71,0.2);">
                <i class="fa-solid fa-paper-plane" style="font-size: 0.85rem;"></i>
            </button>
        </div>
    </div>

    <!-- Floating Button -->
    <button @click="toggleChat()" 
            style="background: linear-gradient(135deg, #1B2A47, #2A3E5C); color: white; width: 60px; height: 60px; border-radius: 50%; border: none; box-shadow: 0 8px 24px rgba(27, 42, 71, 0.3); cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s; float: right; position: relative;"
            onmouseover="this.style.transform='scale(1.08) translateY(-2px)'"
            onmouseout="this.style.transform='scale(1) translateY(0)'">
        <span x-show="!open" style="font-size: 1.6rem;">💬</span>
        <span x-show="open" x-cloak style="font-size: 1.4rem;">✕</span>
        <span x-show="!open && unreadCount() > 0" 
              style="position: absolute; top: -5px; right: -5px; width: 22px; height: 22px; background: #EF4444; border: 2px solid white; border-radius: 50%; color: white; font-size: 11px; font-weight: 800; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 5px rgba(0,0,0,0.2);"
              x-text="unreadCount()"></span>
    </button>
</div>

<script>
function chatWidget() {
    return {
        open: false,
        showEmojis: false,
        messages: [],
        newMessage: '',
        userId: {{ auth()->id() }},
        initChat() {
            // Fetch initial messages once without playing sound
            let url = '/messages?_t=' + Date.now();
            fetch(url, { headers: { 'Cache-Control': 'no-cache', 'Pragma': 'no-cache' } })
                .then(res => res.json())
                .then(data => {
                    this.messages = data;
                    this.updateNavBadge(this.unreadCount());
                    this.scrollDown();
                });

            // Poll every 2 seconds always - fast enough for responsive chat
            setInterval(() => {
                this.fetchMessages();
            }, 2000);
        },
        unreadCount() {
            return this.messages.filter(m => m.sender_id !== this.userId && !m.is_read).length;
        },
        playChime() {
            if (window.DDPhoneAudio) {
                window.DDPhoneAudio.playChat();
            }
        },
        fetchMessages() {
            let url = '/messages?_t=' + Date.now();
            if (this.open) {
                url += '&read=1';
            }
            fetch(url, { headers: { 'Cache-Control': 'no-cache', 'Pragma': 'no-cache' } })
                .then(res => res.json())
                .then(data => {
                    const tempMessages = this.messages.filter(m => String(m.id).startsWith('temp-'));
                    const realLength = this.messages.length - tempMessages.length;
                    
                    if (data.length > realLength) {
                        // Play sound only if it's a new message from someone else (admin)
                        let newAdminMsg = data.slice(realLength).some(m => m.sender_id !== this.userId);
                        if (newAdminMsg) {
                            this.playChime();
                        }
                    }
                    
                    // Always sync state with server
                    this.messages = [...data, ...tempMessages];
                    
                    if (data.length > realLength) {
                        this.scrollDown();
                    }
                    
                    this.updateNavBadge(this.unreadCount());
                });
        },
        updateNavBadge(count) {
            document.querySelectorAll('.customer-nav-chat-badge').forEach(el => {
                if (count > 0) {
                    el.textContent = count;
                    el.style.display = 'inline-block';
                } else {
                    el.style.display = 'none';
                }
            });
        },
        handleFileUpload(e) {
            const file = e.target.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append('attachment', file);
            formData.append('content', this.newMessage);

            fetch('/messages', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                this.messages.push(data);
                this.newMessage = '';
                e.target.value = '';
                this.scrollDown();
            })
            .catch(err => console.error(err));
        },
        sendMessage() {
            if (this.newMessage.trim() === '') return;
            const content = this.newMessage;
            this.newMessage = ''; // Clear instantly
            
            const tempId = 'temp-' + Date.now();
            
            // Optimistic UI update
            this.messages.push({
                id: tempId,
                sender_id: this.userId,
                content: content,
                created_at: new Date().toISOString(),
                attachment_path: null
            });
            this.scrollDown();
            
            fetch('/messages', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ content: content, receiver_id: null })
            })
            .then(res => {
                if (!res.ok) throw new Error('Failed to send message');
                return res.json();
            })
            .then(data => {
                // Remove the temp message
                this.messages = this.messages.filter(m => m.id !== tempId);
                // Add real message if it's not already fetched
                if (!this.messages.some(m => m.id === data.id)) {
                    this.messages.push(data);
                }
                this.scrollDown();
            })
            .catch(err => {
                console.error(err);
                this.messages = this.messages.filter(m => m.id !== tempId);
                alert('เกิดข้อผิดพลาดในการส่งข้อความ กรุณาลองใหม่อีกครั้ง');
            });
        },
        toggleChat() {
            this.open = !this.open;
            if (this.open) {
                this.fetchMessages(); // Immediately mark as read on opening
                this.scrollDown();
            }
        },
        scrollDown() {
            setTimeout(() => {
                const el = document.getElementById('chat-widget-messages');
                if (el) el.scrollTop = el.scrollHeight;
            }, 100);
        }
    };
}
</script>
@endif
