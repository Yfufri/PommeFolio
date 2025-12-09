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
            card.style.transition =
                'opacity 0.4s cubic-bezier(0.22, 1, 0.36, 1), ' +
                'transform 0.4s cubic-bezier(0.22, 1, 0.36, 1)';

            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
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

        const { createApp, computed, ref } = Vue;

        const app = createApp({
            setup() {
                const selectedAnneeId   = ref(annees[0] ? annees[0].id : null);
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
                        return {
                            ...annee,
                            competences: filteredComps
                        };
                    }).filter(a => a.competences.length > 0);
                });

                const currentAnnee = computed(() =>
                    filteredAnnees.value.find(a => a.id === selectedAnneeId.value) || null
                );

                const currentCompetences = computed(() =>
                    currentAnnee.value ? currentAnnee.value.competences : []
                );

                const currentCompetence = computed(() =>
                    currentCompetences.value.find(c => c.id === selectedCompId.value) || null
                );

                const currentAcs = computed(() => {
                    if (!currentCompetence.value) return [];
                    const list = acsParCompetence[currentCompetence.value.id] || [];
                    return list;
                });

                function selectAnnee(id) {
                    selectedAnneeId.value = id;
                    const a = filteredAnnees.value.find(x => x.id === id);
                    selectedCompId.value = (a && a.competences[0]) ? a.competences[0].id : null;
                }

                function selectCompetence(id) {
                    selectedCompId.value = id;
                }

                // init comp sélectionnée par défaut
                if (currentCompetences.value[0]) {
                    selectedCompId.value = currentCompetences.value[0].id;
                }

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
              <div v-for="annee in filteredAnnees"
                   :key="annee.id"
                   class="annee-block">
                <button
                  class="annee-btn"
                  :class="{ 'is-active': annee.id === selectedAnneeId }"
                  @click="selectAnnee(annee.id)">
                  {{ annee.label }}
                </button>

                <ul class="competences-list">
                  <li v-for="comp in annee.competences"
                      :key="comp.id">
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

          <div class="but-explorer-detail card-big" v-if="currentCompetence">
            <div class="card-gradient"></div>
            <h2>
              {{ currentCompetence.code }} – {{ currentCompetence.titre }}
            </h2>
            <p class="competence-description">
              Sélectionne une AC pour voir ce que je sais faire, ou consulte la page détaillée.
            </p>

            <div class="acs-grid">
              <article class="ac-card" v-for="ac in currentAcs" :key="ac.id">
                <div class="ac-header">
                  <span class="ac-code">{{ ac.code }}</span>
                  <h3>{{ ac.titre }}</h3>
                </div>
                <p class="ac-description">{{ ac.description }}</p>
                <a
                  class="btn btn-link"
                  :href="'/but-competence?id=' + currentCompetence.id">
                  Voir les illustrations de cette compétence →
                </a>
              </article>
            </div>
          </div>

          <div v-else class="but-explorer-detail card-big">
            <h2>Aucune compétence trouvée</h2>
            <p>Essaie de modifier ta recherche ou de sélectionner une autre année.</p>
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
