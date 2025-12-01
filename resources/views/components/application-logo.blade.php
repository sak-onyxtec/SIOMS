<svg viewBox="0 0 316 316" xmlns="http://www.w3.org/2000/svg" {{ $attributes }} role="img" aria-label="SIOMS logo">
  <!-- background rounded -->
  <rect x="6" y="6" width="304" height="304" rx="20" ry="20" fill="#ffffff" stroke="#E6E9EE" stroke-width="2"/>

  <!-- Warehouse roof -->
  <path d="M28 92 L158 28 L288 92 V150 H28z" fill="#F3F7FB" stroke="#C9D6EA" stroke-width="2"/>

  <!-- Warehouse body -->
  <rect x="28" y="146" width="260" height="116" rx="8" fill="#FFFFFF" stroke="#C9D6EA" stroke-width="2"/>
  <!-- Door -->
  <rect x="62" y="162" width="56" height="94" rx="4" fill="#F0F6FF" stroke="#B9CFEA" stroke-width="1.5"/>
  <!-- Window panels on door -->
  <rect x="70" y="170" width="16" height="18" rx="2" fill="#DDEEFF"/>
  <rect x="90" y="170" width="16" height="18" rx="2" fill="#DDEEFF"/>

  <!-- Boxes (inventory) -->
  <g transform="translate(150,170)">
    <rect x="-6" y="0" width="48" height="34" rx="3" fill="#FFE9C7" stroke="#E0C29A" stroke-width="1.2"/>
    <rect x="40" y="-6" width="32" height="28" rx="3" fill="#FFD8D8" stroke="#E0B0B0" stroke-width="1.2"/>
    <rect x="8" y="34" width="44" height="28" rx="3" fill="#DFF7E6" stroke="#A9D6B3" stroke-width="1.2"/>
    <!-- box lines -->
    <path d="M-6 12 H42" stroke="#E0C29A" stroke-width="1"/>
    <path d="M40 6 H72" stroke="#E0B0B0" stroke-width="1"/>
    <path d="M8 46 H52" stroke="#A9D6B3" stroke-width="1"/>
  </g>

  <!-- Chart / reports (right side) -->
  <g transform="translate(210,128)">
    <rect x="0" y="24" width="18" height="44" rx="2" fill="#E8F0FF" stroke="#AFC8FF"/>
    <rect x="28" y="8" width="18" height="60" rx="2" fill="#D6EDFF" stroke="#8FC1FF"/>
    <rect x="56" y="0" width="18" height="68" rx="2" fill="#CFF6E8" stroke="#7ED6B9"/>
    <!-- axis -->
    <path d="M-6 72 H96" stroke="#C9D6EA" stroke-width="1.2"/>
    <path d="M-6 0 V72" stroke="#C9D6EA" stroke-width="1.2"/>
  </g>

  <!-- Clipboard / Order icon (top-right) -->
  <g transform="translate(204,48)">
    <rect x="-8" y="6" width="44" height="52" rx="4" fill="#FFF9E6" stroke="#F1DFA4"/>
    <rect x="-2" y="-6" width="28" height="14" rx="3" fill="#FFF" stroke="#E6D8B6"/>
    <path d="M0 18 H20" stroke="#D7B86D" stroke-width="2" stroke-linecap="round"/>
    <path d="M0 28 H20" stroke="#D7B86D" stroke-width="2" stroke-linecap="round"/>
  </g>

  <!-- Shield / lock for roles/auth (left top) -->
  <g transform="translate(68,42)">
    <path d="M18 0 C28 6 34 12 34 22 C34 44 18 58 18 58 C18 58 2 44 2 22 C2 12 8 6 18 0 Z" fill="#EAF7FF" stroke="#9FD0FF" stroke-width="1.6"/>
    <rect x="12" y="20" width="12" height="12" rx="2" fill="#FFFFFF" stroke="#C3E5FF" stroke-width="1.2"/>
    <circle cx="18" cy="26" r="1.6" fill="#9FD0FF"/>
    <path d="M18 32 V36" stroke="#9FD0FF" stroke-width="1.6" stroke-linecap="round"/>
  </g>

  <!-- Subtle decorative grid/lines to hint "system" -->
  <g stroke="#F0F4FA" stroke-width="1">
    <line x1="28" y1="268" x2="288" y2="268"/>
    <line x1="28" y1="252" x2="288" y2="252"/>
    <line x1="28" y1="236" x2="288" y2="236"/>
  </g>

  <!-- Title abbreviation -->
  <g transform="translate(26,284)">
    <text x="0" y="0" font-family="Verdana, Arial, sans-serif" font-size="12" fill="#2E4A6A" font-weight="700">SIOMS</text>
    <text x="48" y="0" font-family="Verdana, Arial, sans-serif" font-size="10" fill="#6B7F96">Smart Inventory & Orders</text>
  </g>
</svg>
