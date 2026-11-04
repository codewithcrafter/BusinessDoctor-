/**
 * BusinessDoctor Interactive Digital Readiness & Project Estimator
 * Evaluates technical needs, growth opportunities, and recommended IT services
 */

document.addEventListener('DOMContentLoaded', () => {
  const calcContainer = document.querySelector('#business-health-calculator');
  if (!calcContainer) return;

  const state = {
    bottleneck: 'conversion',
    revenue: '250k_to_1m',
    model: 'b2b'
  };

  const scoreEl = calcContainer.querySelector('#calc-score-val');
  const urgencyEl = calcContainer.querySelector('#calc-urgency-val');
  const leakageEl = calcContainer.querySelector('#calc-leakage-val');
  const practiceEl = calcContainer.querySelector('#calc-practice-val');
  const actionBtn = calcContainer.querySelector('#calc-action-btn');

  function calculate() {
    let score = 76;
    let urgency = 'High Priority Opportunity';
    let practice = 'Web & Custom Software Development';
    let opportunity = '$20,000 – $80,000 / yr';

    // Need evaluation
    if (state.bottleneck === 'conversion') {
      score -= 20;
      urgency = 'High Priority Opportunity';
      practice = 'Conversion Funnel & UI/UX Optimization';
    } else if (state.bottleneck === 'traffic') {
      score -= 16;
      urgency = 'Growth Scale Priority';
      practice = 'Digital Marketing, Paid Ads & SEO';
    } else if (state.bottleneck === 'technology') {
      score -= 24;
      urgency = 'Immediate Tech Upgrade Recommended';
      practice = 'Custom Web & Software Development';
    } else if (state.bottleneck === 'branding') {
      score -= 14;
      urgency = 'Brand Redesign Opportunity';
      practice = 'UI/UX Design & Brand Identity';
    } else if (state.bottleneck === 'marketplace') {
      score -= 18;
      urgency = 'Marketplace Revenue Expansion';
      practice = 'E-Commerce & Marketplace Management';
    }

    // Revenue scaling
    if (state.revenue === '5m_plus') {
      opportunity = '$100,000 – $400,000+ / yr';
    } else if (state.revenue === '1m_to_5m') {
      opportunity = '$50,000 – $180,000 / yr';
    } else if (state.revenue === '250k_to_1m') {
      opportunity = '$20,000 – $80,000 / yr';
    } else {
      opportunity = '$10,000 – $30,000 / yr';
    }

    // Update UI
    if (scoreEl) scoreEl.textContent = Math.max(34, score);
    if (urgencyEl) {
      urgencyEl.textContent = urgency;
      urgencyEl.className = 'pill-tag ' + (score < 60 ? 'dark' : '');
    }
    if (leakageEl) leakageEl.textContent = opportunity;
    if (practiceEl) practiceEl.textContent = practice;
    
    if (actionBtn) {
      actionBtn.href = `audit.php?bottleneck=${encodeURIComponent(state.bottleneck)}&revenue=${encodeURIComponent(state.revenue)}&model=${encodeURIComponent(state.model)}`;
    }
  }

  // Bind option button clicks
  calcContainer.querySelectorAll('.calc-option-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const group = this.getAttribute('data-group');
      const val = this.getAttribute('data-val');

      calcContainer.querySelectorAll(`.calc-option-btn[data-group="${group}"]`).forEach(b => {
        b.classList.remove('selected');
      });

      this.classList.add('selected');
      state[group] = val;
      calculate();
    });
  });

  calculate();
});
