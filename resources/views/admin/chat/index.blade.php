@extends('layouts.admin')

@section('title', 'Live Chat Pelanggan - Proats Admin CMS')
@section('page_title', 'Live Chat Pelanggan')

@section('content')
<div x-data="adminFullChatApp()" class="h-[calc(100vh-100px)] bg-white rounded-2xl border border-orange-100 overflow-hidden flex shadow-xs">

    <!-- Left Column: Conversations List -->
    <div class="w-80 md:w-96 border-r border-orange-100 flex flex-col bg-gray-50/50 shrink-0">
        
        <!-- Header & Search -->
        <div class="p-4 border-b border-orange-100 bg-white space-y-3 shrink-0">
            <div class="flex items-center justify-between">
                <h3 class="font-extrabold text-sm text-gray-900 flex items-center gap-2">
                    <i class="fas fa-comments text-orange-500"></i> Percakapan Pembeli
                </h3>
                <span class="text-[10px] font-bold bg-orange-100 text-orange-600 px-2 py-0.5 rounded-full" x-text="conversations.length + ' User'"></span>
            </div>
            <div class="relative">
                <i class="fas fa-magnifying-glass absolute left-3 top-3 text-gray-400 text-xs"></i>
                <input type="text" 
                       x-model="search" 
                       placeholder="Cari nama atau email pembeli..." 
                       class="w-full pl-9 pr-3 py-2 text-xs border border-gray-200 rounded-xl focus:outline-none focus:border-orange-500 bg-gray-50">
            </div>
        </div>

        <!-- Conversations List Body -->
        <div class="flex-1 overflow-y-auto divide-y divide-gray-100">
            <template x-if="filteredConversations.length === 0">
                <div class="p-8 text-center text-xs text-gray-400">
                    <i class="fas fa-inbox text-3xl text-gray-300 mb-2"></i>
                    <p>Belum ada percakapan dari pembeli.</p>
                </div>
            </template>

            <template x-for="conv in filteredConversations" :key="conv.user_id">
                <button @click="selectUser(conv.user_id)" 
                        :class="selectedUserId === conv.user_id ? 'bg-orange-50 border-orange-500' : 'hover:bg-gray-100 border-transparent'"
                        class="w-full p-3.5 text-left border-l-4 transition flex items-center gap-3">
                    <div class="relative shrink-0">
                        <img :src="conv.avatar" class="w-10 h-10 rounded-full object-cover border border-gray-200 shadow-xs">
                        <template x-if="conv.unread_count > 0">
                            <span class="absolute -top-1 -right-1 bg-orange-500 text-white font-extrabold text-[9px] w-4 h-4 rounded-full flex items-center justify-center border border-white shadow-xs animate-pulse"></span>
                        </template>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-0.5">
                            <h4 class="font-bold text-xs text-gray-900 truncate" x-text="conv.name"></h4>
                            <span class="text-[10px] text-gray-400 shrink-0 font-medium" x-text="conv.last_time"></span>
                        </div>
                        <p class="text-[11px] text-gray-500 truncate" x-text="conv.last_message || 'Belum ada pesan'"></p>
                    </div>
                    <template x-if="conv.unread_count > 0">
                        <span class="bg-orange-500 text-white font-extrabold text-[10px] px-2 py-0.5 rounded-full shrink-0" x-text="conv.unread_count"></span>
                    </template>
                </button>
            </template>
        </div>
    </div>

    <!-- Right Column: Active Chat Thread -->
    <div class="flex-1 flex flex-col min-w-0 bg-white">

        <!-- Empty State (No User Selected) -->
        <template x-if="!selectedUser">
            <div class="flex-1 flex flex-col items-center justify-center p-8 text-center text-gray-400">
                <div class="w-16 h-16 bg-orange-50 text-orange-500 rounded-full flex items-center justify-center text-2xl mb-3 shadow-xs">
                    <i class="fas fa-comments"></i>
                </div>
                <h3 class="text-base font-bold text-gray-800 mb-1">Pilih Percakapan Pembeli</h3>
                <p class="text-xs text-gray-400 max-w-sm">Pilih salah satu pembeli di sebelah kiri untuk mulai membaca dan membalas chat secara live.</p>
            </div>
        </template>

        <!-- Selected User Chat Thread -->
        <template x-if="selectedUser">
            <div class="flex-1 flex flex-col h-full overflow-hidden">
                
                <!-- Chat Header -->
                <div class="p-4 bg-white border-b border-orange-100 flex items-center justify-between shrink-0 shadow-2xs">
                    <div class="flex items-center gap-3">
                        <img :src="selectedUser.avatar" class="w-10 h-10 rounded-full object-cover border border-orange-200 shadow-xs">
                        <div>
                            <h3 class="font-extrabold text-sm text-gray-900 leading-tight" x-text="selectedUser.name"></h3>
                            <p class="text-[11px] text-gray-400 font-medium" x-text="selectedUser.email"></p>
                        </div>
                    </div>

                    <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Terhubung Live
                    </span>
                </div>

                <!-- Messages Thread Body -->
                <div x-ref="messagesBody" class="flex-1 p-4 md:p-6 overflow-y-auto space-y-4 bg-slate-50 text-xs">
                    <div class="text-center py-2 text-[10px] text-gray-400 font-medium">
                        <span class="bg-white px-3 py-1 rounded-full border border-gray-200 shadow-2xs">Mulai percakapan dengan <span x-text="selectedUser.name" class="font-bold text-gray-700"></span></span>
                    </div>

                    <template x-for="msg in messages" :key="msg.id">
                        <div class="flex flex-col" :class="msg.is_admin ? 'items-end' : 'items-start'">
                            <div class="max-w-[75%] rounded-2xl px-4 py-2.5 text-xs shadow-xs leading-relaxed"
                                 :class="msg.is_admin ? 'bg-orange-500 text-white rounded-tr-none font-medium' : 'bg-white text-gray-800 border border-gray-200 rounded-tl-none'">
                                <p x-text="msg.message" class="whitespace-pre-wrap"></p>
                            </div>
                            <span class="text-[9px] text-gray-400 mt-1 px-1 font-medium" x-text="msg.time"></span>
                        </div>
                    </template>
                </div>

                <!-- Reply Footer Form -->
                <form @submit.prevent="sendAdminReply()" class="p-3.5 bg-white border-t border-orange-100 flex items-center gap-3 shrink-0">
                    <input type="text" 
                           x-model="replyText" 
                           placeholder="Ketik balasan pesan Anda..." 
                           class="flex-1 text-xs p-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-orange-500 focus:bg-white font-medium">
                    <button type="submit" 
                            :disabled="!replyText.trim()" 
                            class="px-5 py-3 bg-orange-500 hover:bg-orange-600 disabled:opacity-50 text-white font-bold text-xs rounded-xl shadow-sm transition flex items-center gap-1.5 shrink-0">
                        <i class="fas fa-paper-plane text-xs"></i>
                        <span>Kirim</span>
                    </button>
                </form>

            </div>
        </template>

    </div>

</div>
@endsection

@section('scripts')
<script>
    function adminFullChatApp() {
        return {
            conversations: [],
            search: '',
            selectedUserId: null,
            selectedUser: null,
            messages: [],
            replyText: '',
            pollInterval: null,

            get filteredConversations() {
                if (!this.search.trim()) return this.conversations;
                const q = this.search.toLowerCase();
                return this.conversations.filter(c => 
                    c.name.toLowerCase().includes(q) || c.email.toLowerCase().includes(q)
                );
            },

            init() {
                this.fetchConversations();
                this.pollInterval = setInterval(() => {
                    this.fetchConversations();
                    if (this.selectedUserId) {
                        this.fetchMessages(this.selectedUserId, false);
                    }
                }, 4000);
            },

            fetchConversations() {
                fetch('/cms-admin/chat/conversations', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => res.json())
                .then(data => {
                    this.conversations = data.conversations || [];
                    if (!this.selectedUserId && this.conversations.length > 0) {
                        this.selectUser(this.conversations[0].user_id);
                    }
                });
            },

            selectUser(userId) {
                this.selectedUserId = userId;
                this.fetchMessages(userId, true);
            },

            fetchMessages(userId, autoScroll = false) {
                fetch('/cms-admin/chat/messages/' + userId, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => res.json())
                .then(data => {
                    this.selectedUser = data.user;
                    this.messages = data.messages;
                    if (autoScroll) {
                        this.$nextTick(() => this.scrollToBottom());
                    }
                });
            },

            sendAdminReply() {
                if (!this.replyText.trim() || !this.selectedUserId) return;
                const text = this.replyText;
                this.replyText = '';

                fetch('/cms-admin/chat/send/' + this.selectedUserId, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ message: text })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.messages.push(data.message);
                        this.fetchConversations();
                        this.$nextTick(() => this.scrollToBottom());
                    }
                });
            },

            scrollToBottom() {
                if (this.$refs.messagesBody) {
                    this.$refs.messagesBody.scrollTop = this.$refs.messagesBody.scrollHeight;
                }
            }
        }
    }
</script>
@endsection
