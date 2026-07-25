@extends('layouts.store')

@section('content')
<div style="font-family: 'Prompt', sans-serif;" x-data="blogApp()">
    <div class="fade-in" style="max-width: 1200px; margin: 0 auto; padding: 3rem 1.5rem;">
    <!-- Hero Banner with Nexora Style -->
    <div class="nexora-hero-canvas text-center mb-12">
        <span class="badge-yellow-fun bounce-fun" style="margin-bottom: 1.25rem;">NEWS & REVIEWS</span>
        <h1 style="font-size: 2.8rem; font-weight: 900; color: #0F172A; margin: 0 0 1.25rem 0; line-height: 1.2;">📰 บทความและรีวิวสมาร์ทโฟนมือสอง</h1>
        <p style="color: #475569; max-width: 750px; margin: 0 auto; font-size: 1.1rem; line-height: 1.7; font-weight: 500;">
            ติดตามข่าวสาร เทคนิคการเลือกซื้อสมาร์ทโฟนมือสองสภาพนางฟ้า รีวิวการใช้งาน และกิจกรรมพิเศษจาก DDPHONE ดีดีโฟน
        </p>
    </div>

    <!-- Toolbar: Search and Filter Tabs -->
    <div style="background: white; border: 2px solid #E2E8F0; border-radius: 22px; padding: 1.5rem 2rem; margin-bottom: 3rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.5rem;">
        
        <!-- Filter Tabs -->
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <button @click="setCategory('all')" :style="category === 'all' ? activeTabStyle : inactiveTabStyle">
                ทั้งหมด
            </button>
            <button @click="setCategory('activities')" :style="category === 'activities' ? activeTabStyle : inactiveTabStyle">
                ข่าวสารและกิจกรรม
            </button>
            <button @click="setCategory('knowledge')" :style="category === 'knowledge' ? activeTabStyle : inactiveTabStyle">
                บทความรีวิว & เทคนิค
            </button>
        </div>

        <!-- Search Bar -->
        <div style="position: relative; width: 300px; max-width: 100%;">
            <input type="text" x-model="searchQuery" placeholder="ค้นหาบทความ..." style="width: 100%; padding: 12px 18px 12px 42px; border: 2px solid #FFE600; border-radius: 14px; font-size: 0.92rem; outline: none; font-family: inherit;" @input="filterArticles()">
            <span style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #FF5722; font-size: 1rem;">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>
        </div>

    </div>

    <!-- Articles Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 2.2rem; margin-bottom: 4rem;">
        
        <template x-for="article in filteredArticles" :key="article.id">
            <div class="premium-card" style="background: white; display: flex; flex-direction: column; cursor: pointer; height: 100%;" @click="openArticle(article)">
                <div style="position: relative; padding-top: 56.25%; overflow: hidden; background: #EDF2F7;">
                    <img :src="article.image" alt="Article image" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s;" onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=600'">
                    <span :style="article.category === 'activities' ? badgeActivitiesStyle : badgeKnowledgeStyle" x-text="article.category === 'activities' ? 'กิจกรรม' : 'บทความ'"></span>
                </div>
                <div style="padding: 1.8rem; display: flex; flex-direction: column; flex-grow: 1;">
                    <span style="font-size: 0.85rem; color: var(--color-grey-light); margin-bottom: 8px;" x-text="article.date"></span>
                    <h3 style="color: var(--color-navy-dark); font-size: 1.2rem; font-weight: 700; margin: 0 0 10px 0; line-height: 1.4;" x-text="article.title"></h3>
                    <p style="color: var(--color-grey); font-size: 0.9rem; line-height: 1.6; margin: 0 0 20px 0; flex-grow: 1;" x-text="article.summary"></p>
                    <span style="color: var(--color-accent); font-weight: 600; font-size: 0.9rem; display: flex; align-items: center; gap: 5px;">
                        อ่านรายละเอียดเพิ่มเติม <i class="fa-solid fa-arrow-right" style="font-size: 0.8rem;"></i>
                    </span>
                </div>
            </div>
        </template>

    </div>

    <!-- Empty State -->
    <div x-show="filteredArticles.length === 0" style="text-align: center; padding: 4rem 1.5rem; background: white; border-radius: 20px; border: 1px solid var(--color-silver);">
        <span style="font-size: 3.5rem; color: var(--color-grey-light);"><i class="fa-regular fa-folder-open"></i></span>
        <h3 style="font-size: 1.3rem; color: var(--color-navy-dark); margin-top: 15px; margin-bottom: 5px;">ไม่พบข่าวสารหรือบทความ</h3>
        <p style="color: var(--color-grey); font-size: 0.95rem; margin: 0;">กรุณาลองเปลี่ยนคำค้นหาใหม่อีกครั้ง</p>
    </div>
    </div>

    <!-- Article Detail Modal -->
    <template x-teleport="body">
        <div x-show="isModalOpen" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 10000; display: flex; align-items: center; justify-content: center; padding: 1.5rem; backdrop-filter: blur(4px);" @click.self="closeArticle()" x-transition x-cloak>
            
            <div style="background: white; width: 100%; max-width: 800px; margin: auto; border-radius: 24px; max-height: 90vh; overflow-y: auto; box-shadow: 0 25px 50px rgba(0,0,0,0.25); position: relative; display: flex; flex-direction: column;" class="fade-in">
            <!-- Modal Close button -->
            <button @click="closeArticle()" style="position: absolute; top: 20px; right: 20px; background: rgba(0,0,0,0.06); border: none; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 1.2rem; color: var(--color-navy-dark); transition: background 0.2s; z-index: 10;" onmouseover="this.style.background='rgba(0,0,0,0.1)';" onmouseout="this.style.background='rgba(0,0,0,0.06)';">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <!-- Modal Images Grid -->
            <div x-show="selectedArticle.images && selectedArticle.images.length > 0" style="position: relative; width: 100%; background: #EDF2F7; flex-shrink: 0; padding: 1.5rem; border-bottom: 1px solid var(--color-silver);">
                <div style="display: flex; gap: 10px; overflow-x: auto; padding-bottom: 10px; snap-type: x mandatory;">
                    <template x-for="(img, idx) in selectedArticle.images" :key="idx">
                        <img :src="img" alt="Article details" style="height: 250px; width: auto; object-fit: contain; border-radius: 8px; background: white; box-shadow: 0 4px 6px rgba(0,0,0,0.05); snap-align: center;" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=800'">
                    </template>
                </div>
            </div>
            <div x-show="!selectedArticle.images || selectedArticle.images.length === 0" style="position: relative; width: 100%; padding-top: 50%; overflow: hidden; background: #EDF2F7; flex-shrink: 0;">
                <img :src="selectedArticle.image" alt="Article details" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=800'">
            </div>

            <!-- Modal Content Body -->
            <div style="padding: 2.5rem; overflow-y: auto;">
                <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 12px;">
                    <span :style="selectedArticle.category === 'activities' ? badgeActivitiesStyle : badgeKnowledgeStyle" x-text="selectedArticle.category === 'activities' ? 'กิจกรรม' : 'บทความ'"></span>
                    <span style="font-size: 0.9rem; color: var(--color-grey-light);" x-text="selectedArticle.date"></span>
                </div>
                
                <h2 style="color: var(--color-navy-dark); font-size: 1.8rem; font-weight: 700; margin-top: 0; margin-bottom: 1.5rem; line-height: 1.4;" x-text="selectedArticle.title"></h2>
                
                <p style="color: var(--color-grey); font-size: 1.05rem; line-height: 1.8; margin-bottom: 1.5rem; white-space: pre-wrap; font-weight: 500;" x-text="selectedArticle.summary"></p>
                <div style="width: 100%; height: 1px; background: var(--color-silver); margin: 2rem 0;"></div>
                <div style="color: var(--color-grey); font-size: 1.02rem; line-height: 1.8; margin: 0; white-space: pre-wrap;" x-html="selectedArticle.content"></div>
            </div>
            
            <!-- Modal Footer -->
            <div style="padding: 1.5rem 2.5rem; background: var(--color-grey-bg); border-top: 1px solid var(--color-silver-light); display: flex; justify-content: flex-end; border-radius: 0 0 24px 24px; flex-shrink: 0;">
                <button @click="closeArticle()" style="background: var(--color-navy); color: white; border: none; padding: 10px 24px; border-radius: 10px; font-weight: 600; cursor: pointer; font-size: 0.95rem; transition: background 0.2s;" onmouseover="this.style.background='var(--color-navy-light)';" onmouseout="this.style.background='var(--color-navy)';">ปิดหน้าต่าง</button>
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
                border: '1.5px solid #FFC700',
                padding: '10px 22px',
                borderRadius: '12px',
                fontWeight: '800',
                fontSize: '0.92rem',
                cursor: 'pointer',
                transition: 'all 0.2s',
                boxShadow: '0 4px 12px rgba(255,230,0,0.3)'
            },
            inactiveTabStyle: {
                background: '#F8FAFC',
                color: '#475569',
                border: '1.5px solid #E2E8F0',
                padding: '10px 22px',
                borderRadius: '12px',
                fontWeight: '700',
                fontSize: '0.92rem',
                cursor: 'pointer',
                transition: 'all 0.2s'
            },
            badgeActivitiesStyle: {
                position: 'absolute',
                top: '15px',
                left: '15px',
                background: '#E2E8F0',
                color: 'var(--color-navy-dark)',
                fontSize: '0.8rem',
                fontWeight: '700',
                padding: '4px 12px',
                borderRadius: '20px'
            },
            badgeKnowledgeStyle: {
                position: 'absolute',
                top: '15px',
                left: '15px',
                background: 'rgba(49, 130, 206, 0.1)',
                color: 'var(--color-accent)',
                fontSize: '0.8rem',
                fontWeight: '700',
                padding: '4px 12px',
                borderRadius: '20px'
            },
            articles: {!! json_encode(isset($articles) ? $articles->map(function($a) { 
                return [
                    'id' => $a->id, 
                    'title' => $a->title, 
                    'category' => 'activities', 
                    'date' => $a->created_at->format('d M Y'), 
                    'image' => $a->images && count($a->images) > 0 ? Storage::url($a->images[0]) : 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=600', 
                    'summary' => Str::limit(strip_tags($a->content), 100), 
                    'content' => nl2br(e($a->content)), 
                    'images' => $a->images ? collect($a->images)->map(fn($img) => Storage::url($img))->toArray() : []
                ]; 
            })->toArray() : []) !!},
            filteredArticles: [],
            init() {
                this.filterArticles();
            },
            setCategory(cat) {
                this.category = cat;
                this.filterArticles();
            },
            filterArticles() {
                this.filteredArticles = this.articles.filter(article => {
                    const matchesCategory = this.category === 'all' || article.category === this.category;
                    const matchesSearch = article.title.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                                          article.summary.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                                          article.content.toLowerCase().includes(this.searchQuery.toLowerCase());
                    return matchesCategory && matchesSearch;
                });
            },
            openArticle(article) {
                this.selectedArticle = article;
                this.isModalOpen = true;
            },
            closeArticle() {
                this.isModalOpen = false;
            }
        };
    };
</script>
@endsection
