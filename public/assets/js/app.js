// public/assets/js/app.js

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
            if (isDark) {
                switchEl.classList.add('is-on');
            } else {
                switchEl.classList.remove('is-on');
            }
        }
    }

    function initDarkMode() {
        const saved = localStorage.getItem(STORAGE_KEY);
        let isDark = saved === 'dark';

        if (saved === null) {
            const prefersDark = window.matchMedia &&
                window.matchMedia('(prefers-color-scheme: dark)').matches;
            isDark = prefersDark;
        }

        applyTheme(isDark);

        const switchEl = document.querySelector('.darkmode-switch');
        if (switchEl) {
            switchEl.addEventListener('click', () => {
                isDark = !document.body.classList.contains('dark');
                applyTheme(isDark);
                localStorage.setItem(STORAGE_KEY, isDark ? 'dark' : 'light');
            });
        }
    }

    function initCardAnimations() {
        const animatedCards = document.querySelectorAll(
            '.card, .card-big, .culture-card, .ac-card, .admin-card'
        );

        animatedCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(12px)';
            card.style.transition = 'opacity 0.4s ease, transform 0.4s ease';

            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';

                // Nettoyage pour laisser le CSS (.card:hover) reprendre la main
                setTimeout(() => {
                    card.style.opacity = '';
                    card.style.transform = '';
                    card.style.transition = '';
                }, 500);

            }, 80 + index * 70);
        });
    }

    function initHeroParallax() {
        const hero = document.querySelector('.hero');
        if (!hero) return;

        window.addEventListener('scroll', () => {
            const offset = window.scrollY;
            hero.style.transform = `translateY(${offset * 0.08}px)`;
        });
    }

    // --- App VueJS pour l’explorateur BUT ---
    function initButExplorerVue() {
        const explorerEl = document.getElementById('but-explorer');
        if (!explorerEl || typeof Vue === 'undefined') return;

        const rawAnnees = explorerEl.getAttribute('data-annees');
        const rawAcs    = explorerEl.getAttribute('data-acs');

        let annees = [];
        let acsParCompetence = {};

        try {
            annees = JSON.parse(rawAnnees || '[]');
            acsParCompetence = JSON.parse(rawAcs || '{}');
        } catch (e) {
            console.error('Erreur parsing BUT data', e);
        }

        const { createApp, computed, ref, onMounted } = Vue;

        const app = createApp({
            setup() {
                const selectedAnneeId   = ref(null);
                const selectedCompId    = ref(null);
                const searchText        = ref('');

                const filteredAnnees = computed(() => {
                    if (!searchText.value) return annees;
                    const q = searchText.value.toLowerCase();
                    return annees.map(annee => {
                        const filteredComps = (annee.competences || []).filter(c =>
                            (c.code || '').toLowerCase().includes(q) ||
                            (c.titre || '').toLowerCase().includes(q)
                        );
                        return { ...annee, competences: filteredComps };
                    }).filter(a => a.competences.length > 0);
                });

                const currentAnnee = computed(() =>
                    annees.find(a => a.id === selectedAnneeId.value) || null
                );

                const currentCompetences = computed(() =>
                    currentAnnee.value ? currentAnnee.value.competences : []
                );

                const currentCompetence = computed(() =>
                    currentCompetences.value.find(c => c.id === selectedCompId.value) || null
                );

                const currentAcs = computed(() => {
                    if (!selectedCompId.value) return [];
                    const idKey = String(selectedCompId.value);
                    return acsParCompetence[idKey] || [];
                });

                function selectAnnee(id) {
                    selectedAnneeId.value = id;
                    const annee = annees.find(x => x.id === id);
                    if (annee && annee.competences && annee.competences.length > 0) {
                        selectedCompId.value = annee.competences[0].id;
                    } else {
                        selectedCompId.value = null;
                    }
                }

                function selectCompetence(id) {
                    selectedCompId.value = id;
                }

                onMounted(() => {
                    if (annees.length > 0) {
                        selectedAnneeId.value = annees[0].id;
                        if (annees[0].competences && annees[0].competences.length > 0) {
                            selectedCompId.value = annees[0].competences[0].id;
                        }
                    }
                });

                return {
                    searchText,
                    filteredAnnees,
                    selectedAnneeId,
                    selectedCompId,
                    currentAnnee,
                    currentCompetences,
                    currentCompetence,
                    currentAcs,
                    selectAnnee,
                    selectCompetence
                };
            },
            template: `
              <div class="but-explorer-inner">
                <div class="but-explorer-sidebar card">
                  <h2>Années & compétences</h2>
                  <div class="form-group">
                    <label>Rechercher une compétence</label>
                    <input type="text" v-model="searchText" placeholder="C1, C2, système, web...">
                  </div>

                  <div class="annees-list">
                    <div v-for="annee in filteredAnnees" :key="annee.id" class="annee-block">
                      <button
                          class="annee-btn"
                          :class="{ 'is-active': annee.id === selectedAnneeId }"
                          @click="selectAnnee(annee.id)">
                        {{ annee.label }}
                      </button>

                      <ul class="competences-list">
                        <li v-for="comp in annee.competences" :key="comp.id">
                          <button
                              class="competence-btn"
                              :class="{ 'is-active': comp.id === selectedCompId }"
                              @click="selectCompetence(comp.id)">
                            <span class="code">{{ comp.code }}</span>
                            <span class="titre">{{ comp.titre }}</span>
                          </button>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>

                <div class="but-explorer-detail card" v-if="currentCompetence">
                  <h2>{{ currentCompetence.code }} – {{ currentCompetence.titre }}</h2>
                  <p class="competence-description">
                    Sélectionne une AC pour voir les détails ou consulte la page complète.
                  </p>

                  <div class="acs-grid">
                    <article class="ac-card" v-for="ac in currentAcs" :key="ac.id">
                      <div class="ac-header">
                        <span class="ac-code">{{ ac.code }}</span>
                        <h3>{{ ac.titre }}</h3>
                      </div>
                      <p class="ac-description">{{ ac.description }}</p>
                      <a class="btn btn-link" :href="'but/competence?id=' + currentCompetence.id">
                        Voir les illustrations →
                      </a>
                    </article>
                  </div>
                  <div v-if="currentAcs.length === 0" class="mt-2">
                    <p>Aucun acquis d'apprentissage enregistré pour cette compétence.</p>
                  </div>
                </div>

                <div v-else class="but-explorer-detail card">
                  <h2>Aucune sélection</h2>
                  <p>Sélectionne une compétence dans la barre latérale pour afficher les détails.</p>
                </div>
              </div>
            `
        });

        app.mount('#but-explorer');
    }

    document.addEventListener('DOMContentLoaded', () => {
        initDarkMode();
        initCardAnimations();
        initHeroParallax();
        initButExplorerVue();
    });
})();