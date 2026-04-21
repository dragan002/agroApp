import sharp from 'sharp';

const svg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="512" height="512">
  <defs>
    <linearGradient id="bg" x1="0" y1="0" x2="0.6" y2="1">
      <stop offset="0%" stop-color="#4d7248"/>
      <stop offset="100%" stop-color="#2a4427"/>
    </linearGradient>
    <linearGradient id="gold" x1="0" y1="0" x2="0" y2="1">
      <stop offset="0%" stop-color="#d4a84b"/>
      <stop offset="100%" stop-color="#a07830"/>
    </linearGradient>
  </defs>

  <!-- App icon rounded square background -->
  <rect width="512" height="512" rx="108" ry="108" fill="url(#bg)"/>

  <!-- Subtle texture ring -->
  <rect width="512" height="512" rx="108" ry="108" fill="none" stroke="rgba(255,255,255,0.06)" stroke-width="10"/>

  <!-- ===================== WHEAT ===================== -->
  <!-- Central stalk -->
  <line x1="256" y1="400" x2="256" y2="120" stroke="#faf0dc" stroke-width="10" stroke-linecap="round" opacity="0.9"/>

  <!-- TOP grain (upright) -->
  <ellipse cx="256" cy="130" rx="18" ry="30" fill="url(#gold)"/>
  <line x1="256" y1="108" x2="256" y2="160" stroke="#c89030" stroke-width="3" stroke-linecap="round" opacity="0.5"/>

  <!-- === Pair 1 === y=175 -->
  <!-- Left grain -->
  <g transform="translate(256,175)">
    <g transform="rotate(-50)">
      <ellipse cx="0" cy="-28" rx="14" ry="26" fill="url(#gold)"/>
      <line x1="0" y1="-8" x2="0" y2="-48" stroke="#c89030" stroke-width="2.5" opacity="0.45"/>
    </g>
  </g>
  <!-- Right grain -->
  <g transform="translate(256,175)">
    <g transform="rotate(50)">
      <ellipse cx="0" cy="-28" rx="14" ry="26" fill="url(#gold)"/>
      <line x1="0" y1="-8" x2="0" y2="-48" stroke="#c89030" stroke-width="2.5" opacity="0.45"/>
    </g>
  </g>

  <!-- === Pair 2 === y=218 -->
  <g transform="translate(256,218)">
    <g transform="rotate(-55)">
      <ellipse cx="0" cy="-28" rx="14" ry="26" fill="url(#gold)"/>
    </g>
  </g>
  <g transform="translate(256,218)">
    <g transform="rotate(55)">
      <ellipse cx="0" cy="-28" rx="14" ry="26" fill="url(#gold)"/>
    </g>
  </g>

  <!-- === Pair 3 === y=260 -->
  <g transform="translate(256,260)">
    <g transform="rotate(-58)">
      <ellipse cx="0" cy="-26" rx="13" ry="24" fill="url(#gold)"/>
    </g>
  </g>
  <g transform="translate(256,260)">
    <g transform="rotate(58)">
      <ellipse cx="0" cy="-26" rx="13" ry="24" fill="url(#gold)"/>
    </g>
  </g>

  <!-- === Pair 4 === y=298 -->
  <g transform="translate(256,298)">
    <g transform="rotate(-60)">
      <ellipse cx="0" cy="-24" rx="12" ry="22" fill="url(#gold)" opacity="0.9"/>
    </g>
  </g>
  <g transform="translate(256,298)">
    <g transform="rotate(60)">
      <ellipse cx="0" cy="-24" rx="12" ry="22" fill="url(#gold)" opacity="0.9"/>
    </g>
  </g>

  <!-- === Leaf pair at bottom of wheat head === -->
  <!-- Left leaf -->
  <path d="M252,330 C235,318 200,308 192,285 C220,290 248,320 252,330Z" fill="#7ab86a" opacity="0.95"/>
  <line x1="252" y1="330" x2="200" y2="291" stroke="#5a9a4a" stroke-width="2" stroke-linecap="round" opacity="0.6"/>
  <!-- Right leaf -->
  <path d="M260,345 C278,330 315,322 322,298 C294,305 264,338 260,345Z" fill="#7ab86a" opacity="0.95"/>
  <line x1="260" y1="345" x2="315" y2="303" stroke="#5a9a4a" stroke-width="2" stroke-linecap="round" opacity="0.6"/>

  <!-- Ground arc / base -->
  <ellipse cx="256" cy="400" rx="48" ry="8" fill="#faf0dc" opacity="0.18"/>
</svg>`;

async function makeIcon(size, filename) {
  await sharp(Buffer.from(svg))
    .resize(size, size)
    .png()
    .toFile(`public/icons/${filename}`);
  console.log(`✓ ${filename} (${size}×${size})`);
}

await makeIcon(512, 'icon-512.png');
await makeIcon(192, 'icon-192.png');
await makeIcon(48,  'icon-48.png');
await makeIcon(72,  'icon-72.png');
await makeIcon(96,  'icon-96.png');
await makeIcon(144, 'icon-144.png');
console.log('Done.');
