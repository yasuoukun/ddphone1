@extends('layouts.store')

@section('content')
<style>
    @keyframes funPulseBadge {
        0%, 100% { transform: scale(1); box-shadow: 0 0 10px rgba(255, 230, 0, 0.4); }
        50% { transform: scale(1.04); box-shadow: 0 0 20px rgba(255, 230, 0, 0.8); }
    }
    .fun-pulse-badge {
        animation: funPulseBadge 3s ease-in-out infinite !important;
    }
    .article-card-fun {
        transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s ease !important;
    }
    .article-card-fun:hover {
        transform: translateY(-6px) scale(1.015) !important;
        box-shadow: 0 15px 30px rgba(15, 23, 42, 0.12) !important;
    }
</style>

<div style="font-family: 'Prompt', sans-serif;" x-data="blogApp()">
    <div class="fade-in" style="max-width: 1200px; margin: 0 auto; padding: 3rem 1.5rem;">

        <!-- Header Section (Section 6) -->
        <div style="text-align: center; margin-bottom: 3rem;">
            <span class="fun-pulse-badge" style="display: inline-block; background: #FFE600; color: #0F172A; padding: 6px 20px; border-radius: 99px; font-size: 0.85rem; font-weight: 900; margin-bottom: 1rem; letter-spacing: 0.5px;">
                🎉 BLOGS & REVIEWS FUN ZONE
            </span>
            <h1 style="font-size: 2.6rem; font-weight: 900; color: #0F172A; margin: 0 0 1rem; line-height: 1.25;">
                📰 ข่าวสาร บทความ และรีวิวสมาร์ทโฟนมือสอง
            </h1>
            <p style="color: #64748B; max-width: 720px; margin: 0 auto; font-size: 1.05rem; line-height: 1.6; font-weight: 700;">
                อัปเดตสาระน่ารู้ เทคนิคเลือกซื้อสมาร์ทโฟนมือสองสภาพนางฟ้า กิจกรรมสนุกๆ และรีวิวการใช้งานจากร้าน DDPHONE ดีดีโฟน
            </p>
        </div>

        <!-- Toolbar: Real-time Search and Category Filter Tabs -->
        <div style="background: white; border: 2px solid #E2E8F0; border-radius: 24px; padding: 1.5rem 2rem; margin-bottom: 3.5rem; box-shadow: 0 6px 20px rgba(15, 23, 42, 0.04); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.5rem;">
            
            <!-- Filter Tabs -->
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <button @click="setCategory('all')" :style="category === 'all' ? activeTabStyle : inactiveTabStyle">
                    🌟 ทั้งหมด
                </button>
                <button @click="setCategory('activities')" :style="category === 'activities' ? activeTabStyle : inactiveTabStyle">
                    🎉 ข่าวสารและกิจกรรม
                </button>
                <button @click="setCategory('knowledge')" :style="category === 'knowledge' ? activeTabStyle : inactiveTabStyle">
                    📱 บทความรีวิว & เทคนิค
                </button>
            </div>

            <!-- Real-time Search Bar (Section 6) -->
            <div style="position: relative; width: 320px; max-width: 100%;">
                <input type="text" x-model="searchQuery" @input="filterArticles()" placeholder="🔍 พิมพ์ค้นหาบทความแบบเรียลไทม์..." 
                       style="width: 100%; padding: 12px 18px 12px 44px; border: 2px solid #2563EB; border-radius: 99px; font-size: 0.92rem; outline: none; font-family: inherit; font-weight: 800; color: #0F172A; background: #F8FAFC; transition: all 0.2s;"
                       onfocus="this.style.background='white'; this.style.boxShadow='0 0 0 4px rgba(37, 99, 235, 0.15)'"
                       onblur="this.style.background='#F8FAFC'; this.style.boxShadow='none'">
                <span style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #2563EB; font-size: 1.1rem;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
            </div>

        </div>

        <!-- Articles Grid (Fun Design) -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 2.2rem; margin-bottom: 4.5rem;">
            
            <template x-for="article in filteredArticles" :key="article.id">
                <div class="article-card-fun" style="background: white; border: 1.5px solid #E2E8F0; border-radius: 24px; overflow: hidden; display: flex; flex-direction: column; cursor: pointer; height: 100%; box-shadow: 0 4px 15px rgba(15,23,42,0.04);" @click="openArticle(article)">
                    <div style="position: relative; padding-top: 56.25%; overflow: hidden; background: #0F172A;">
                        <img :src="article.image" alt="Article image" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s;" onmouseover="this.style.transform='scale(1.08)';" onmouseout="this.style.transform='scale(1)';" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=600'">
                        <span :style="article.category === 'activities' ? badgeActivitiesStyle : badgeKnowledgeStyle" x-text="article.category === 'activities' ? '🎉 กิจกรรม' : '📱 รีวิว & เทคนิค'"></span>
                    </div>
                    <div style="padding: 1.8rem; display: flex; flex-direction: column; flex-grow: 1; justify-content: space-between; background: #FAFAFA;">
                        <div>
                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                                <span style="font-size: 0.8rem; color: #64748B; font-weight: 800;" x-text="article.date"></span>
                            </div>
                            <h3 style="color: #0F172A; font-size: 1.2rem; font-weight: 900; margin: 0 0 10px 0; line-height: 1.35; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;" x-text="article.title"></h3>
                            <p style="color: #64748B; font-size: 0.9rem; line-height: 1.6; margin: 0 0 20px 0; font-weight: 600; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;" x-text="article.summary"></p>
                        </div>
                        <div style="border-top: 1px solid #F1F5F9; padding-top: 1rem; margin-top: auto;">
                            <span style="color: #0F172A; font-weight: 900; font-size: 0.88rem; display: flex; align-items: center; gap: 6px;" onmouseover="this.style.color='#2563EB'" onmouseout="this.style.color='#0F172A'">
                                อ่านบทความรายละเอียดเต็ม ➔
                            </span>
                        </div>
                    </div>
                </div>
            </template>

        </div>

        <!-- Real-time Empty State -->
        <div x-show="filteredArticles.length === 0" style="text-align: center; padding: 4rem 1.5rem; background: white; border-radius: 24px; border: 1.5px solid #E2E8F0; box-shadow: 0 4px 15px rgba(15,23,42,0.04);">
            <span style="font-size: 3.5rem; color: #94A3B8;"><i class="fa-regular fa-folder-open"></i></span>
            <h3 style="font-size: 1.3rem; color: #0F172A; font-weight: 900; margin-top: 15px; margin-bottom: 5px;">ไม่พบข่าวสารหรือบทความรีวิว</h3>
            <p style="color: #64748B; font-size: 0.95rem; margin: 0; font-weight: 700;">กรุณาลองพิมพ์คำค้นหาใหม่อีกครั้ง</p>
        </div>
    </div>

    <!-- Article Detail Modal (Full Page Viewport Modal) -->
    <template x-teleport="body">
        <div x-show="isModalOpen" 
             style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(15, 23, 42, 0.85); z-index: 99999999; overflow-y: auto; padding: 2rem 1rem; backdrop-filter: blur(8px);" 
             @click.self="closeArticle()" 
             x-transition:enter="transition ease-out duration-250"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             x-cloak>
            
            <div style="background: #FFFFFF; width: 100%; max-width: 1020px; margin: 1.5rem auto; border-radius: 28px; box-shadow: 0 30px 70px rgba(0,0,0,0.4); position: relative; overflow: hidden; border: 1px solid rgba(255,255,255,0.2);" class="fade-in">
                
                <!-- Floating Glass Close Button -->
                <button @click="closeArticle()" style="position: absolute; top: 20px; right: 20px; background: rgba(15, 23, 42, 0.75); color: #FFE600; border: 1.5px solid rgba(255,255,255,0.2); border-radius: 50%; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 1.25rem; transition: all 0.2s; z-index: 20; backdrop-filter: blur(4px);" onmouseover="this.style.transform='scale(1.1)'; this.style.background='#0F172A';" onmouseout="this.style.transform='scale(1)'; this.style.background='rgba(15, 23, 42, 0.75)';" title="ปิดหน้าต่าง">
                    <i class="fa-solid fa-xmark"></i>
                </button>

                <!-- Modal Images Showcase Banner -->
                <div x-show="selectedArticle.images && selectedArticle.images.length > 0" style="position: relative; width: 100%; background: #0F172A; padding: 2rem 1.5rem; border-bottom: 3px solid #E2E8F0;">
                    <div style="display: flex; gap: 16px; overflow-x: auto; padding-bottom: 12px; snap-type: x mandatory; scrollbar-width: thin;">
                        <template x-for="(img, idx) in selectedArticle.images" :key="idx">
                            <div style="flex-shrink: 0; snap-align: center;">
                                <img :src="img" alt="Article details" style="height: 380px; max-width: 100%; width: auto; object-fit: contain; border-radius: 16px; background: #0F172A; box-shadow: 0 10px 25px rgba(0,0,0,0.3);" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=800'">
                            </div>
                        </template>
                    </div>
                </div>
                <div x-show="!selectedArticle.images || selectedArticle.images.length === 0" style="position: relative; width: 100%; height: 380px; overflow: hidden; background: #0F172A;">
                    <img :src="selectedArticle.image" alt="Article details" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=800'">
                </div>

                <!-- Modal Content Container -->
                <div style="padding: 3rem 3.5rem;">
                    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px; margin-bottom: 1.25rem;">
                        <span style="background: #2563EB; color: white; padding: 6px 18px; border-radius: 99px; font-size: 0.85rem; font-weight: 900; letter-spacing: 0.5px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);">
                            🎉 ข่าวสาร & กิจกรรม DDPHONE
                        </span>
                        <span style="font-size: 0.95rem; color: #64748B; font-weight: 800; display: flex; align-items: center; gap: 6px;">
                            📅 <span x-text="selectedArticle.date"></span>
                        </span>
                    </div>
                    
                    <h1 style="color: #0F172A; font-size: clamp(1.6rem, 3.5vw, 2.2rem); font-weight: 900; margin-top: 0; margin-bottom: 1.75rem; line-height: 1.35;" x-text="selectedArticle.title"></h1>
                    
                    <div style="background: #F8FAFC; border-left: 5px solid #2563EB; padding: 1.25rem 1.75rem; border-radius: 0 16px 16px 0; margin-bottom: 2rem;">
                        <p style="color: #334155; font-size: 1.08rem; line-height: 1.8; margin: 0; white-space: pre-wrap; font-weight: 700;" x-text="selectedArticle.summary"></p>
                    </div>

                    <div style="width: 100%; height: 1.5px; background: #E2E8F0; margin: 2rem 0;"></div>

                    <div style="color: #1E293B; font-size: 1.08rem; line-height: 1.95; margin: 0; white-space: pre-wrap; font-weight: 500;" x-html="selectedArticle.content"></div>
                    
                    <template x-if="selectedArticle.author">
                        <div style="margin-top: 3rem; padding-top: 1.5rem; border-top: 1.5px dashed #E2E8F0; display: flex; align-items: center; gap: 12px; color: #64748B; font-weight: 700; font-size: 0.95rem;">
                            <span style="width: 36px; height: 36px; border-radius: 50%; background: #0F172A; color: #FFE600; display: inline-flex; align-items: center; justify-content: center; font-size: 0.9rem;"><i class="fa-solid fa-pen-nib"></i></span>
                            <span>เขียนโดย: <strong style="color: #0F172A;" x-text="selectedArticle.author"></strong></span>
                        </div>
                    </template>
                </div>
                
                <!-- Modal Sticky Footer -->
                <div style="padding: 1.25rem 3.5rem; background: #F8FAFC; border-top: 1.5px solid #E2E8F0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; border-radius: 0 0 28px 28px;">
                    <span style="color: #64748B; font-size: 0.88rem; font-weight: 700;">ร้านดีดีโฟน DDPHONE - สมาร์ทโฟนมือสองคุณภาพเกรด A+</span>
                    <button @click="closeArticle()" style="background: #0F172A; color: #FFE600; border: none; padding: 12px 32px; border-radius: 99px; font-weight: 900; cursor: pointer; font-size: 0.95rem; transition: all 0.2s; box-shadow: 0 4px 12px rgba(15,23,42,0.2);" onmouseover="this.style.background='#1E293B'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='#0F172A'; this.style.transform='translateY(0)';">ปิดหน้าต่าง</button>
                </div>
            </div>
        </div>
    </template>

</div>

<script>
    window.blogApp = function() {
        return {
            category: 'all',
            searchQuery: '',
            isModalOpen: false,
            selectedArticle: {},
            activeTabStyle: {
                background: '#FFE600',
                color: '#0F172A',
                border: '1.5px solid #0F172A',
                padding: '10px 22px',
                borderRadius: '99px',
                fontWeight: '900',
                fontSize: '0.92rem',
                cursor: 'pointer',
                transition: 'all 0.2s',
                boxShadow: '0 4px 12px rgba(255,230,0,0.35)'
            },
            inactiveTabStyle: {
                background: '#F8FAFC',
                color: '#0F172A',
                border: '1.5px solid #E2E8F0',
                padding: '10px 22px',
                borderRadius: '99px',
                fontWeight: '800',
                fontSize: '0.92rem',
                cursor: 'pointer',
                transition: 'all 0.2s'
            },
            badgeActivitiesStyle: {
                position: 'absolute',
                top: '15px',
                left: '15px',
                background: '#2563EB',
                color: 'white',
                padding: '5px 14px',
                borderRadius: '99px',
                fontSize: '0.78rem',
                fontWeight: '900',
                boxShadow: '0 4px 10px rgba(37, 99, 235, 0.4)',
                zIndex: '2'
            },
            badgeKnowledgeStyle: {
                position: 'absolute',
                top: '15px',
                left: '15px',
                background: '#FFE600',
                color: '#0F172A',
                padding: '5px 14px',
                borderRadius: '99px',
                fontSize: '0.78rem',
                fontWeight: '900',
                boxShadow: '0 4px 10px rgba(255, 230, 0, 0.4)',
                zIndex: '2'
            },
            articles: [
                @if(isset($articles) && count($articles) > 0)
                    @foreach($articles as $art)
                    @php
                        // images is already cast as array by Eloquent model
                        $imgs = $art->images ?? [];
                        // Build full URL for each image
                        $allImgUrls = array_map(function($i) {
                            return str_starts_with($i, 'http') ? $i : Storage::url($i);
                        }, $imgs);
                        // First image as cover
                        $coverImg = count($allImgUrls) > 0
                            ? $allImgUrls[0]
                            : 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&q=80&w=600';
                        $summary = Str::limit(strip_tags($art->content), 150);
                    @endphp
                    {
                        id: {{ $art->id }},
                        title: {!! json_encode($art->title) !!},
                        category: "activities",
                        summary: {!! json_encode($summary) !!},
                        content: {!! json_encode(nl2br(e($art->content))) !!},
                        date: "{{ $art->created_at ? $art->created_at->format('d/m/Y') : date('d/m/Y') }}",
                        author: {!! json_encode($art->author_name ?? '') !!},
                        image: {!! json_encode($coverImg) !!},
                        images: {!! json_encode($allImgUrls) !!}
                    },
                    @endforeach
                @else
                    {
                        id: 1,
                        title: 'สาธิตวิธีตรวจเช็คไอโฟนมือสองเกรด A+ ก่อนส่งถึงมือลูกค้า',
                        category: 'knowledge',
                        summary: 'แนะนำเทคนิคและขั้นตอนการตรวจเช็คสุขภาพแบตเตอรี่ กล้อง สแกนนิ้ว หน้าจอแท้ และประวัติเครื่องแท้ 100% โดยทีมช่าง DDPHONE',
                        content: 'ทีมงาน DDPHONE ดีดีโฟน ตรวจสอบคุณภาพสินค้าทุกเครื่องอย่างละเอียดมากกว่า 30 รายการก่อนจัดส่ง เพื่อให้ลูกค้ามั่นใจว่าจะได้รับสมาร์ทโฟนมือสองคุณภาพสูง สภาพสวย 99% พร้อมรับประกันร้าน 30 วันเต็ม',
                        date: '{{ date("d/m/Y") }}',
                        image: 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&q=80&w=600',
                        images: []
                    },
                    {
                        id: 2,
                        title: 'กิจกรรมส่งมอบ iPad และสมาร์ทโฟนเพื่อสนับสนุนสื่อการเรียนการสอน',
                        category: 'activities',
                        summary: 'DDPHONE ร่วมเป็นส่วนหนึ่งในการสนับสนุนไอแพดและสมาร์ทโฟนเพื่อการศึกษาแก่นักเรียนนักศึกษาในภูมิภาค',
                        content: 'ดีดีโฟนจัดกิจกรรมส่งมอบแท็บเล็ตและอุปกรณ์ไอทีเพื่อการศึกษาแก่โรงเรียนและสถาบันการศึกษาเพื่อใช้ส่งเสริมสื่อการเรียนการสอนในยุคดิจิทัล',
                        date: '{{ date("d/m/Y") }}',
                        image: 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&q=80&w=600',
                        images: []
                    }
                @endif
            ],
            filteredArticles: [],

            init() {
                this.filterArticles();
                this.$watch('searchQuery', () => {
                    this.filterArticles();
                });
            },

            setCategory(cat) {
                this.category = cat;
                this.filterArticles();
            },

            filterArticles() {
                let q = this.searchQuery.toLowerCase().trim();
                this.filteredArticles = this.articles.filter(item => {
                    let matchesCategory = (this.category === 'all') || (item.category === this.category);
                    let titleMatch = item.title ? item.title.toLowerCase().includes(q) : false;
                    let summaryMatch = item.summary ? item.summary.toLowerCase().includes(q) : false;
                    let contentMatch = item.content ? item.content.toLowerCase().includes(q) : false;
                    let matchesQuery = !q || titleMatch || summaryMatch || contentMatch;
                    return matchesCategory && matchesQuery;
                });
            },

            openArticle(article) {
                this.selectedArticle = article;
                this.isModalOpen = true;
                document.body.style.overflow = 'hidden';
            },

            closeArticle() {
                this.isModalOpen = false;
                document.body.style.overflow = 'auto';
            }
        }
    }
</script>
@endsection
