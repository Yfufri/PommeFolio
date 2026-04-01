(function () {
    const STORAGE_KEY = 'portfolio-theme';

    function applyTheme(isDark) {
        if (isDark) {
            document.body.classList.add('dark');
        } else {
            document.body.classList.remove('dark');
        }
        const switchEl = document.querySelector('.darkmode-switch');
        if (switchEl) {
            isDark ? switchEl.classList.add('is-on') : switchEl.classList.remove('is-on');
        }
    }

    function initDarkMode() {
        const saved = localStorage.getItem(STORAGE_KEY);
        let isDark = saved === 'dark' || (saved === null && window.matchMedia('(prefers-color-scheme: dark)').matches);
        applyTheme(isDark);

        document.addEventListener('click', (e) => {
            if (e.target.closest('.darkmode-switch')) {
                isDark = !document.body.classList.contains('dark');
                applyTheme(isDark);
                localStorage.setItem(STORAGE_KEY, isDark ? 'dark' : 'light');
            }
        });
    }

    function initLightbox() {
        let overlay = document.querySelector('.lightbox-overlay') || document.createElement('div');
        if (!overlay.parentElement) {
            overlay.classList.add('lightbox-overlay');
            overlay.innerHTML = '<img src="" alt="Agrandissement">';
            document.body.appendChild(overlay);
        }
        const overlayImg = overlay.querySelector('img');

        document.addEventListener('click', (e) => {
            const img = e.target.closest('.illu-thumb img, .illu-card img, .voyage-paris-item img');
            if (img) {
                overlayImg.src = img.src;
                overlay.classList.add('is-active');
                document.body.style.overflow = 'hidden';
            }
        });

        overlay.addEventListener('click', () => {
            overlay.classList.remove('is-active');
            document.body.style.overflow = '';
        });
    }

    function initCardAnimations() {
        const cards = document.querySelectorAll('.card, .card-big, .culture-card, .ac-card, .admin-card');
        cards.forEach((card, i) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(12px)';
            card.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
                setTimeout(() => { card.style.transition = ''; }, 500);
            }, 80 + i * 70);
        });
    }

    function initButExplorerVue() {
        const explorerEl = document.getElementById('but-explorer');
        if (!explorerEl || typeof Vue === 'undefined') return;

        let annees = [], acsParComp = {};
        try {
            annees = JSON.parse(explorerEl.getAttribute('data-annees') || '[]');
            acsParComp = JSON.parse(explorerEl.getAttribute('data-acs') || '{}');
        } catch (e) { console.error('Erreur JSON', e); return; }

        const { createApp, computed, ref, onMounted } = Vue;
        createApp({
            setup() {
                const selectedAnneeId = ref(null), selectedCompId = ref(null), searchText = ref(''), isTransitioning = ref(false);

                const currentAnnee = computed(() => annees.find(a => a.id === selectedAnneeId.value));
                const currentCompetence = computed(() => (currentAnnee.value?.competences || []).find(c => c.id === selectedCompId.value));
                const currentAcs = computed(() => acsParComp[String(selectedCompId.value)] || []);

                const currentFilteredCompetences = computed(() => {
                    const a = annees.find(x => x.id === selectedAnneeId.value);
                    if (!a) return [];
                    if (!searchText.value) return a.competences || [];
                    const q = searchText.value.toLowerCase();
                    return (a.competences || []).filter(c =>
                        c.code.toLowerCase().includes(q) || c.titre.toLowerCase().includes(q));
                });

                // keep filteredAnnees for search compatibility (used in tab visibility)
                const filteredAnnees = computed(() => annees);

                const selectAnnee = (id) => {
                    selectedAnneeId.value = id;
                    const a = annees.find(x => x.id === id);
                    if (a?.competences?.length > 0) selectedCompId.value = a.competences[0].id;
                };

                const selectCompetence = (comp, anneeId) => {
                    isTransitioning.value = true;
                    setTimeout(() => {
                        selectedAnneeId.value = anneeId;
                        selectedCompId.value = comp.id;
                        isTransitioning.value = false;
                    }, 150);
                };

                onMounted(() => {
                    const params = new URLSearchParams(window.location.search);
                    const compIdStr = params.get('comp');
                    if (compIdStr) {
                        const compId = parseInt(compIdStr);
                        for (const a of annees) {
                            const c = (a.competences || []).find(x => x.id === compId);
                            if (c) { selectedAnneeId.value = a.id; selectedCompId.value = compId; return; }
                        }
                    }
                    if (annees.length > 0) selectAnnee(annees[0].id);
                });

                return { searchText, filteredAnnees, selectedAnneeId, selectedCompId, currentCompetence, currentAcs, currentFilteredCompetences, selectAnnee, selectCompetence, isTransitioning };
            },
            template: `
              <div class="but-explorer-inner">
                <div class="but-explorer-sidebar card">
                  <div class="annee-tabs">
                    <button v-for="a in filteredAnnees" :key="a.id" class="annee-tab" :class="{'is-active': a.id === selectedAnneeId}" @click="selectAnnee(a.id)">{{a.label}}</button>
                  </div>
                  <div class="form-group"><input type="text" v-model="searchText" placeholder="Rechercher..."></div>
                  <ul class="competences-list">
                    <li v-for="c in currentFilteredCompetences" :key="c.id">
                      <button class="competence-btn" :class="{'is-active': c.id === selectedCompId}" @click="selectCompetence(c, selectedAnneeId)">
                        <span class="code">{{c.code}}</span><span class="titre">{{c.titre}}</span>
                      </button>
                    </li>
                  </ul>
                </div>
                <div class="but-explorer-detail card" :style="{ opacity: isTransitioning ? 0 : 1, transition: 'opacity 0.2s' }" v-if="currentCompetence">
                  <h2>{{currentCompetence.code}} – {{currentCompetence.titre}}</h2>
                  <div class="acs-grid">
                    <article class="ac-card" v-for="ac in currentAcs" :key="ac.id">
                      <div class="ac-header"><span class="ac-code">{{ac.code}}</span><h3>{{ac.titre}}</h3></div>
                      <p class="ac-description">{{ac.description}}</p>
                      <a class="btn btn-link" :href="'but/competence?id=' + currentCompetence.id">Voir les illustrations →</a>
                    </article>
                  </div>
                </div>
              </div>`
        }).mount('#but-explorer');
    }

    document.addEventListener('DOMContentLoaded', () => {
        initDarkMode();
        initCardAnimations();
        initButExplorerVue();
        initLightbox();
    });
})();