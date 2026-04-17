<?php
$dataFile = __DIR__ . "/data/projects.json";
$data = json_decode(file_get_contents($dataFile), true);
$dev = $data["developer"];
$projects = $data["projects"];
$skills = $data["skills"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= htmlspecialchars($dev["name"]) ?> — Portfolio</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Mono:wght@300;400;500&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --bg: #0a0a0f;
      --surface: #111118;
      --border: #1e1e2e;
      --accent: #7fff6e;
      --accent2: #4fffea;
      --text: #e8e8f0;
      --muted: #6b6b80;
      --card: #13131c;
    }

    html { scroll-behavior: smooth; }

    body {
      font-family: 'DM Mono', monospace;
      background: var(--bg);
      color: var(--text);
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* NOISE OVERLAY */
    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
      pointer-events: none;
      z-index: 0;
      opacity: 0.4;
    }

    /* NAV */
    nav {
      position: fixed;
      top: 0; left: 0; right: 0;
      z-index: 100;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1.2rem 3rem;
      background: rgba(10,10,15,0.85);
      backdrop-filter: blur(12px);
      border-bottom: 1px solid var(--border);
    }

    .nav-logo {
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: 1.1rem;
      color: var(--accent);
      text-decoration: none;
      letter-spacing: -0.02em;
    }

    .nav-links { display: flex; gap: 2rem; }
    .nav-links a {
      color: var(--muted);
      text-decoration: none;
      font-size: 0.8rem;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      transition: color 0.2s;
    }
    .nav-links a:hover { color: var(--accent); }

    /* HERO */
    .hero {
      min-height: 100vh;
      display: flex;
      align-items: center;
      padding: 0 3rem;
      position: relative;
      z-index: 1;
    }

    .hero-inner { max-width: 900px; }

    .hero-badge {
      display: inline-block;
      font-size: 0.75rem;
      color: var(--accent);
      border: 1px solid var(--accent);
      padding: 0.3rem 0.8rem;
      border-radius: 100px;
      margin-bottom: 2rem;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      animation: fadeUp 0.6s ease both;
    }

    .hero h1 {
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: clamp(3rem, 8vw, 7rem);
      line-height: 0.95;
      letter-spacing: -0.04em;
      margin-bottom: 1.5rem;
      animation: fadeUp 0.7s ease both;
      animation-delay: 0.1s;
    }

    .hero h1 span { color: var(--accent); }

    .hero-desc {
      font-size: 1rem;
      color: var(--muted);
      max-width: 500px;
      line-height: 1.7;
      margin-bottom: 2.5rem;
      animation: fadeUp 0.7s ease both;
      animation-delay: 0.2s;
    }

    .hero-cta {
      display: flex;
      gap: 1rem;
      flex-wrap: wrap;
      animation: fadeUp 0.7s ease both;
      animation-delay: 0.3s;
    }

    .btn {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.85rem 1.8rem;
      border-radius: 6px;
      font-family: 'DM Mono', monospace;
      font-size: 0.85rem;
      text-decoration: none;
      transition: all 0.2s;
      cursor: pointer;
      border: none;
    }

    .btn-primary {
      background: var(--accent);
      color: #0a0a0f;
      font-weight: 500;
    }
    .btn-primary:hover { background: #6de85e; transform: translateY(-2px); }

    .btn-outline {
      background: transparent;
      color: var(--text);
      border: 1px solid var(--border);
    }
    .btn-outline:hover { border-color: var(--accent); color: var(--accent); transform: translateY(-2px); }

    /* GLOW ORB */
    .glow-orb {
      position: fixed;
      width: 600px; height: 600px;
      background: radial-gradient(circle, rgba(127,255,110,0.06) 0%, transparent 70%);
      border-radius: 50%;
      top: -100px; right: -100px;
      pointer-events: none;
      z-index: 0;
    }

    /* SECTIONS */
    section {
      padding: 6rem 3rem;
      position: relative;
      z-index: 1;
      max-width: 1100px;
      margin: 0 auto;
    }

    .section-label {
      font-size: 0.7rem;
      color: var(--accent);
      letter-spacing: 0.15em;
      text-transform: uppercase;
      margin-bottom: 0.75rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    .section-label::before {
      content: '';
      display: inline-block;
      width: 24px; height: 1px;
      background: var(--accent);
    }

    .section-title {
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: clamp(2rem, 4vw, 3.5rem);
      letter-spacing: -0.03em;
      margin-bottom: 3rem;
      line-height: 1;
    }

    /* PROJECTS GRID */
    .projects-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
      gap: 1.5rem;
    }

    .project-card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 2rem;
      transition: all 0.3s;
      position: relative;
      overflow: hidden;
    }

    .project-card::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 2px;
      background: linear-gradient(90deg, var(--accent), var(--accent2));
      transform: scaleX(0);
      transform-origin: left;
      transition: transform 0.3s;
    }

    .project-card:hover { border-color: rgba(127,255,110,0.3); transform: translateY(-4px); }
    .project-card:hover::before { transform: scaleX(1); }

    .project-card.featured { grid-column: span 1; }

    .card-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 1rem;
    }

    .featured-badge {
      font-size: 0.65rem;
      color: var(--accent);
      background: rgba(127,255,110,0.1);
      border: 1px solid rgba(127,255,110,0.2);
      padding: 0.2rem 0.6rem;
      border-radius: 100px;
      letter-spacing: 0.05em;
    }

    .project-links { display: flex; gap: 0.75rem; }
    .project-links a {
      color: var(--muted);
      font-size: 0.75rem;
      text-decoration: none;
      letter-spacing: 0.05em;
      transition: color 0.2s;
    }
    .project-links a:hover { color: var(--accent); }

    .project-title {
      font-family: 'Syne', sans-serif;
      font-weight: 700;
      font-size: 1.3rem;
      margin-bottom: 0.75rem;
    }

    .project-desc {
      color: var(--muted);
      font-size: 0.85rem;
      line-height: 1.7;
      margin-bottom: 1.5rem;
    }

    .tags { display: flex; flex-wrap: wrap; gap: 0.5rem; }
    .tag {
      font-size: 0.7rem;
      color: var(--accent2);
      background: rgba(79,255,234,0.08);
      border: 1px solid rgba(79,255,234,0.15);
      padding: 0.25rem 0.6rem;
      border-radius: 4px;
      letter-spacing: 0.04em;
    }

    /* SKILLS */
    .skills-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 0.75rem;
    }

    .skill-item {
      font-size: 0.85rem;
      color: var(--text);
      background: var(--card);
      border: 1px solid var(--border);
      padding: 0.6rem 1.2rem;
      border-radius: 6px;
      transition: all 0.2s;
    }

    .skill-item:hover {
      border-color: var(--accent);
      color: var(--accent);
    }

    /* CONTACT */
    .contact-box {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 3rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 2rem;
    }

    .contact-box h3 {
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: 2rem;
      letter-spacing: -0.03em;
    }

    .contact-box p {
      color: var(--muted);
      font-size: 0.9rem;
      margin-top: 0.5rem;
    }

    /* FOOTER */
    footer {
      border-top: 1px solid var(--border);
      padding: 2rem 3rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      color: var(--muted);
      font-size: 0.75rem;
      position: relative;
      z-index: 1;
    }

    /* ANIMATIONS */
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(24px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .reveal {
      opacity: 0;
      transform: translateY(30px);
      transition: opacity 0.6s ease, transform 0.6s ease;
    }
    .reveal.visible { opacity: 1; transform: translateY(0); }

    /* DIVIDER */
    .divider {
      border: none;
      border-top: 1px solid var(--border);
      max-width: 1100px;
      margin: 0 auto;
    }

    @media (max-width: 768px) {
      nav { padding: 1rem 1.5rem; }
      .hero { padding: 0 1.5rem; padding-top: 5rem; }
      section { padding: 4rem 1.5rem; }
      footer { flex-direction: column; gap: 0.5rem; text-align: center; }
      .contact-box { padding: 2rem; }
    }
  </style>
</head>
<body>

<div class="glow-orb"></div>

<!-- NAV -->
<nav>
  <a class="nav-logo" href="#"><?= htmlspecialchars($dev["name"]) ?></a>
  <div class="nav-links">
    <a href="#projects">Projects</a>
    <a href="#skills">Skills</a>
    <a href="#contact">Contact</a>
  </div>
</nav>

<!-- HERO -->
<div class="hero">
  <div class="hero-inner">
    <div class="hero-badge">&#x2022; Available for work</div>
    <h1>
      <?php
        $nameParts = explode(" ", $dev["name"]);
        echo htmlspecialchars($nameParts[0]);
        if (count($nameParts) > 1) {
          echo " <span>" . htmlspecialchars(implode(" ", array_slice($nameParts, 1))) . "</span>";
        }
      ?>
    </h1>
    <p class="hero-desc"><?= htmlspecialchars($dev["bio"]) ?></p>
    <div class="hero-cta">
      <a href="#projects" class="btn btn-primary">View My Work</a>
      <a href="<?= htmlspecialchars($dev["github"]) ?>" target="_blank" class="btn btn-outline">GitHub ↗</a>
    </div>
  </div>
</div>

<hr class="divider">

<!-- PROJECTS -->
<section id="projects">
  <div class="section-label">Portfolio</div>
  <h2 class="section-title">My Projects</h2>

  <div class="projects-grid">
    <?php foreach ($projects as $project): ?>
    <div class="project-card <?= $project['featured'] ? 'featured' : '' ?> reveal">
      <div class="card-header">
        <?php if ($project['featured']): ?>
          <span class="featured-badge">★ Featured</span>
        <?php else: ?>
          <span></span>
        <?php endif; ?>
        <div class="project-links">
          <?php if (!empty($project['github'])): ?>
            <a href="<?= htmlspecialchars($project['github']) ?>" target="_blank">GitHub ↗</a>
          <?php endif; ?>
          <?php if (!empty($project['live'])): ?>
            <a href="<?= htmlspecialchars($project['live']) ?>" target="_blank">Live ↗</a>
          <?php endif; ?>
        </div>
      </div>
      <h3 class="project-title"><?= htmlspecialchars($project['title']) ?></h3>
      <p class="project-desc"><?= htmlspecialchars($project['description']) ?></p>
      <div class="tags">
        <?php foreach ($project['tags'] as $tag): ?>
          <span class="tag"><?= htmlspecialchars($tag) ?></span>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<hr class="divider">

<!-- SKILLS -->
<section id="skills">
  <div class="section-label">Toolkit</div>
  <h2 class="section-title">Skills</h2>
  <div class="skills-grid">
    <?php foreach ($skills as $skill): ?>
      <div class="skill-item reveal"><?= htmlspecialchars($skill) ?></div>
    <?php endforeach; ?>
  </div>
</section>

<hr class="divider">

<!-- CONTACT -->
<section id="contact">
  <div class="contact-box reveal">
    <div>
      <h3>Let's work together.</h3>
      <p>Have a project in mind? I'd love to hear about it.</p>
    </div>
    <div style="display:flex; gap:1rem; flex-wrap:wrap;">
      <a href="mailto:<?= htmlspecialchars($dev["email"]) ?>" class="btn btn-primary">Send Email</a>
      <a href="<?= htmlspecialchars($dev["linkedin"]) ?>" target="_blank" class="btn btn-outline">LinkedIn ↗</a>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <span>Built with PHP + JSON &mdash; Hosted on Render</span>
  <span>&copy; <?= date('Y') ?> <?= htmlspecialchars($dev["name"]) ?></span>
</footer>

<script>
  // Scroll reveal
  const reveals = document.querySelectorAll('.reveal');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry, i) => {
      if (entry.isIntersecting) {
        setTimeout(() => entry.target.classList.add('visible'), i * 80);
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1 });
  reveals.forEach(el => observer.observe(el));
</script>

</body>
</html>
