<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <title>Finanza - Controle suas finanças de forma simples e eficaz</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/welcome.css', 'resources/js/welcome.js'])
  </head>
  <body>
    <header class="header">
      <div class="container">
        <div class="logo">Finanza</div>
        <button class="menu-toggle" aria-label="Abrir menu">
          <span></span>
          <span></span>
          <span></span>
        </button>
        <nav class="nav-menu">
          <a href="#inicio">Início</a>
          <a href="#funcionalidades">Funcionalidades</a>
          <a href="{{ route('login') }}">Entrar</a>
          <a href="{{ route('register') }}" class="cta-button">Experimente grátis</a>
        </nav>
      </div>
    </header>

    <main>
      <section id="inicio" class="hero">
        <div class="container">
          <div class="hero-content">
            <h1>Controle suas finanças de forma simples e eficaz com o Finanza.</h1>
            <p class="subtitle">O Finanza é a solução definitiva para organizar seu orçamento, acompanhar seus gastos e atingir seus objetivos financeiros com facilidade.</p>
            <a href="{{ route('register') }}" class="cta-button">Experimente agora grátis</a>
          </div>
          <div class="hero-image">
            <img src="https://images.unsplash.com/photo-1579621970795-87facc2f976d?w=800&auto=format&fit=crop&q=80" alt="Dashboard financeiro mostrando gráficos e estatísticas" />
          </div>
        </div>
      </section>

      <section id="funcionalidades" class="features">
        <div class="container">
          <h2>O que você pode fazer com o Finanza?</h2>
          <div class="features-grid">
            <div class="feature-card">
              <div class="feature-icon">📊</div>
              <h3>Controle de Despesas e Receitas</h3>
              <p>Visualize e categorize suas despesas e receitas de maneira intuitiva e em tempo real.</p>
            </div>
            <div class="feature-card">
              <div class="feature-icon">💰</div>
              <h3>Orçamentos Personalizados</h3>
              <p>Crie orçamentos mensais de acordo com suas metas e acompanhe seu progresso.</p>
            </div>
            <div class="feature-card">
              <div class="feature-icon">📈</div>
              <h3>Relatórios e Gráficos</h3>
              <p>Gere relatórios e gráficos detalhados para entender melhor sua saúde financeira.</p>
            </div>
            <div class="feature-card">
              <div class="feature-icon">🏦</div>
              <h3>Sincronização Automática</h3>
              <p>Conecte suas contas bancárias e cartões de crédito para atualizar automaticamente suas transações.</p>
            </div>
            <div class="feature-card">
              <div class="feature-icon">🎯</div>
              <h3>Planejamento de Objetivos</h3>
              <p>Defina metas financeiras, como poupança para viagens ou compras grandes, e acompanhe seu progresso.</p>
            </div>
          </div>
        </div>
      </section>

      <section class="how-it-works">
        <div class="container">
          <h2>Como o Finanza funciona?</h2>
          <div class="steps">
            <div class="step">
              <div class="step-number">1</div>
              <p>Cadastre-se rapidamente e conecte suas contas bancárias ou insira manualmente suas transações.</p>
            </div>
            <div class="step">
              <div class="step-number">2</div>
              <p>Defina seu orçamento mensal e objetivos financeiros com base nas suas metas.</p>
            </div>
            <div class="step">
              <div class="step-number">3</div>
              <p>Acompanhe sua evolução com relatórios e alertas inteligentes para não ultrapassar seu orçamento.</p>
            </div>
          </div>
          <img src="https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=800&auto=format&fit=crop&q=80" alt="Como funciona o Finanza" class="how-it-works-image" />
        </div>
      </section>

      <section id="experimente" class="final-cta">
        <div class="container">
          <h2>Está pronto para transformar suas finanças?</h2>
          <p>Experimente o Finanza agora mesmo e descubra como controlar suas finanças pode ser fácil e rápido.</p>
          <a href="{{route('register') }}" class="cta-button">Experimente grátis</a>
        </div>
      </section>
    </main>

    <footer class="footer">
      <div class="container">
        <div class="footer-content">
          <div class="logo">Finanza</div>
          <div class="footer-links">
            <a href="#inicio">Início</a>
            <a href="#funcionalidades">Funcionalidades</a>
            <a href="{{ route('register') }}">Experimente grátis</a>
          </div>
        </div>
        <p class="copyright">© 2025 Finanza. Todos os direitos reservados.</p>
      </div>
    </footer>
  </body>
</html>