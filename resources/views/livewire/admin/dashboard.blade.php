<style>
    @keyframes float-soft { from { transform: translateY(0); } to { transform: translateY(-10px); } }
    @keyframes fade-in-up { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="relative min-h-screen bg-gradient-to-br from-[#fbeae2] via-[#fff8f4] to-[#f3e5dc] text-brew-brown">
    <div class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute -left-10 top-10 w-60 h-60 bg-brew-light-brown/15 blur-3xl rounded-full animate-[float-soft_6s_ease-in-out_infinite_alternate]"></div>
        <div class="absolute right-0 bottom-10 w-72 h-72 bg-brew-orange/10 blur-3xl rounded-full animate-[float-soft_7s_ease-in-out_infinite_alternate]"></div>
        <div class="absolute left-1/2 -translate-x-1/2 top-32 w-full max-w-5xl h-64 bg-white/40 rounded-3xl shadow-[0_40px_120px_rgba(0,0,0,0.06)]"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 lg:px-8 py-10">
        <div class="grid lg:grid-cols-[260px,1fr] gap-8">
            <aside class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/60 p-6 h-fit sticky top-6" style="animation: fade-in-up 0.7s ease forwards;">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-brew-brown text-white flex items-center justify-center font-display text-2xl shadow-lg">B</div>
                    <div>
                        <p class="text-xs uppercase text-gray-500">BrewBreeze</p>
                        <p class="text-lg font-bold text-brew-brown">Admin Panel</p>
                    </div>
                </div>
                <div class="space-y-1 text-sm font-semibold text-brew-brown">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl transition-all bg-brew-brown text-white shadow-md">
                        <span class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 12l9-8 9 8"></path>
                                <path d="M9 21V9h6v12"></path>
                            </svg>
                        </span>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-brew-light-brown/15 transition-all">
                        <span class="w-8 h-8 rounded-lg bg-brew-light-brown/25 flex items-center justify-center">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="7" width="18" height="13" rx="2"></rect>
                                <path d="M3 11h18"></path>
                            </svg>
                        </span>
                        Products
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-brew-light-brown/15 transition-all">
                        <span class="w-8 h-8 rounded-lg bg-brew-light-brown/25 flex items-center justify-center">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 6h16"></path>
                                <path d="M4 12h16"></path>
                                <path d="M4 18h16"></path>
                            </svg>
                        </span>
                        Orders
                    </a>
                    <a href="{{ route('admin.subscriptions.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-brew-light-brown/15 transition-all">
                        <span class="w-8 h-8 rounded-lg bg-brew-light-brown/25 flex items-center justify-center">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16v4H4z"></path>
                                <path d="M4 12h16v8H4z"></path>
                            </svg>
                        </span>
                        Subscriptions
                    </a>
                    <a href="{{ route('admin.messages.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-brew-light-brown/15 transition-all">
                        <span class="w-8 h-8 rounded-lg bg-brew-light-brown/25 flex items-center justify-center">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 6h16v9H5l-1 3z"></path>
                            </svg>
                        </span>
                        Messages
                    </a>
                </div>
                <div class="mt-6 p-4 rounded-xl bg-brew-light-brown/10 border border-brew-light-brown/30">
                    <p class="text-xs uppercase text-gray-500 mb-2">Quick actions</p>
                    <div class="space-y-3 text-sm font-semibold">
                        <a href="{{ route('admin.products.index') }}" class="flex items-center justify-between px-3 py-2 rounded-lg bg-white/70 border border-white/40 shadow-sm hover:shadow-md transition">
                            <span>Add product</span>
                            <span>+</span>
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="flex items-center justify-between px-3 py-2 rounded-lg bg-white/70 border border-white/40 shadow-sm hover:shadow-md transition">
                            <span>View orders</span>
                            <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </aside>

            <main class="space-y-8" style="animation: fade-in-up 0.8s ease forwards;">
                <div class="bg-white/80 backdrop-blur-xl rounded-2xl p-6 shadow-lg border border-white/60 flex flex-col gap-4">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Welcome back, Admin</p>
                            <h1 class="text-3xl font-bold text-brew-brown">Dashboard Overview</h1>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="relative w-72 max-w-full" id="admin-tool-search-wrap">
                                <input id="admin-tool-search" type="text" placeholder="Search admin tools" class="w-full rounded-2xl border border-brew-light-brown/50 bg-white/80 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brew-orange/50 shadow-inner" autocomplete="off" />
                                <button id="admin-tool-search-btn" type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-brew-brown" aria-label="Search tools">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="7"></circle>
                                        <line x1="16.65" y1="16.65" x2="21" y2="21"></line>
                                    </svg>
                                </button>
                                <div id="admin-tool-search-results" class="absolute z-20 mt-2 w-full rounded-xl border border-brew-light-brown/40 bg-white/95 shadow-lg backdrop-blur-sm hidden"></div>
                            </div>
                            <div class="relative" id="admin-profile-wrap">
                                <button id="admin-profile-btn" type="button" class="w-11 h-11 rounded-2xl bg-brew-brown text-white flex items-center justify-center font-bold shadow-lg focus:outline-none focus:ring-2 focus:ring-brew-orange/50" aria-haspopup="true" aria-expanded="false">
                                    A
                                </button>
                                <div id="admin-profile-menu" class="hidden absolute right-0 mt-3 w-48 bg-white/95 border border-brew-light-brown/40 rounded-xl shadow-xl backdrop-blur-sm py-2 z-30">
                                    <a href="{{ route('profile.show') }}" class="block px-4 py-3 text-sm font-semibold text-brew-brown hover:bg-brew-light-brown/10">Profile</a>
                                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-3 text-sm font-semibold text-brew-brown hover:bg-brew-light-brown/10">Sign out</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid gap-4 md:grid-cols-3">
                        <div class="rounded-2xl p-5 bg-gradient-to-br from-white to-brew-light-brown/20 border border-white/60 shadow-[0_20px_60px_rgba(0,0,0,0.06)]">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs uppercase text-gray-500">Total Orders</p>
                                    <p class="text-3xl font-bold text-brew-brown">{{ $stats['total_orders'] }}</p>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-brew-light-brown/30 flex items-center justify-center">🧾</div>
                            </div>
                            <div class="mt-3 h-2 w-full rounded-full bg-brew-light-brown/20 overflow-hidden">
                                <div class="h-full bg-brew-orange/80 rounded-full" style="width: 78%;"></div>
                            </div>
                        </div>
                        <div class="rounded-2xl p-5 bg-gradient-to-br from-white to-brew-light-brown/20 border border-white/60 shadow-[0_20px_60px_rgba(0,0,0,0.06)]">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs uppercase text-gray-500">Total Customers</p>
                                    <p class="text-3xl font-bold text-brew-brown">{{ $stats['total_customers'] }}</p>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-brew-light-brown/30 flex items-center justify-center">👥</div>
                            </div>
                            <div class="mt-3 h-2 w-full rounded-full bg-brew-light-brown/20 overflow-hidden">
                                <div class="h-full bg-brew-orange/80 rounded-full" style="width: 64%;"></div>
                            </div>
                        </div>
                        <div class="rounded-2xl p-5 bg-gradient-to-br from-white to-brew-light-brown/20 border border-white/60 shadow-[0_20px_60px_rgba(0,0,0,0.06)]">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs uppercase text-gray-500">Total Products</p>
                                    <p class="text-3xl font-bold text-brew-brown">{{ $stats['total_products'] }}</p>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-brew-light-brown/30 flex items-center justify-center">☕</div>
                            </div>
                            <div class="mt-3 h-2 w-full rounded-full bg-brew-light-brown/20 overflow-hidden">
                                <div class="h-full bg-brew-orange/80 rounded-full" style="width: 52%;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 bg-white/80 backdrop-blur-xl rounded-2xl p-6 shadow-lg border border-white/60">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-xs uppercase text-gray-500">Sales analytics</p>
                                <h2 class="text-xl font-bold text-brew-brown">Last 7 days</h2>
                            </div>
                            <div class="flex gap-2 text-xs">
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brew-orange/15 text-brew-brown"><span class="w-3 h-3 rounded-full bg-brew-orange"></span>Revenue</span>
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brew-light-brown/25 text-brew-brown"><span class="w-3 h-3 rounded-full bg-brew-light-brown"></span>Orders</span>
                            </div>
                        </div>
                        <div class="h-80 md:h-96">
                            <canvas id="ordersChart" class="w-full h-full"></canvas>
                        </div>
                    </div>

                    <div class="bg-white/80 backdrop-blur-xl rounded-2xl p-6 shadow-lg border border-white/60">
                        <p class="text-xs uppercase text-gray-500">Trending coffee</p>
                        <h2 class="text-xl font-bold text-brew-brown mb-4">Top sellers</h2>
                        <div class="space-y-3">
                            @forelse($topProducts as $product)
                                <div class="flex items-center justify-between p-3 rounded-xl bg-brew-light-brown/10 border border-white/60">
                                    <div>
                                        <p class="text-sm font-semibold">{{ $product->product->name ?? 'Product' }}</p>
                                        <p class="text-xs text-gray-600">{{ $product->total_qty }} sold</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-bold text-brew-brown">${{ number_format($product->total_revenue, 2) }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">No products sold yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-lg border border-white/60 overflow-hidden">
                    <div class="p-6 flex items-center justify-between">
                        <div>
                            <p class="text-xs uppercase text-gray-500">Recent Orders</p>
                            <h2 class="text-xl font-bold text-brew-brown">Latest activity</h2>
                        </div>
                        <a href="{{ route('admin.orders.index') }}" class="text-sm font-semibold text-brew-brown hover:text-brew-orange transition inline-flex items-center gap-1">
                            <span>View all</span>
                            <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-brew-light-brown/10 text-gray-600 uppercase text-xs">
                                <tr>
                                    <th class="px-6 py-3 text-left">Order</th>
                                    <th class="px-6 py-3 text-left">Customer</th>
                                    <th class="px-6 py-3 text-left">Total</th>
                                    <th class="px-6 py-3 text-left">Status</th>
                                    <th class="px-6 py-3 text-left">Date</th>
                                    <th class="px-6 py-3 text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-brew-light-brown/20">
                                @forelse($recentOrders as $order)
                                    <tr class="hover:bg-brew-light-brown/10 transition">
                                        <td class="px-6 py-4 font-semibold text-brew-brown">#{{ $order->order_id }}</td>
                                        <td class="px-6 py-4 text-gray-700">{{ $order->customer->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 text-brew-brown font-semibold">${{ number_format($order->total, 2) }}</td>
                                        <td class="px-6 py-4">
                                            @php
                                                $statusColors = [
                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                    'processing' => 'bg-blue-100 text-blue-800',
                                                    'completed' => 'bg-green-100 text-green-800',
                                                    'cancelled' => 'bg-red-100 text-red-800',
                                                    'paid' => 'bg-green-100 text-green-800',
                                                ];
                                                $color = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $color }}">{{ ucfirst($order->status) }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-gray-600">
                                            {{ $order->date ? $order->date->format('M j, Y') : ($order->created_at ? $order->created_at->format('M j, Y') : 'N/A') }}
                                        </td>
                                        <td class="px-6 py-4 text-brew-brown font-semibold">
                                            <a href="{{ route('admin.orders.index') }}" class="hover:text-brew-orange transition">Details</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-6 text-center text-gray-500">No orders found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
@php
    $adminTools = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Products', 'url' => route('admin.products.index')],
        ['label' => 'Orders', 'url' => route('admin.orders.index')],
        ['label' => 'Subscriptions', 'url' => route('admin.subscriptions.index')],
        ['label' => 'Messages', 'url' => route('admin.messages.index')],
        ['label' => 'Add Product', 'url' => route('admin.products.index')],
        ['label' => 'View Orders', 'url' => route('admin.orders.index')],
    ];
@endphp

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const ctx = document.getElementById('ordersChart');
        if (!ctx) return;

        const labels = @json($orderTrend['labels']);
        const orders = @json($orderTrend['orders']);
        const revenue = @json($orderTrend['revenue']);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels,
                datasets: [
                    {
                        label: 'Revenue',
                        data: revenue,
                        borderColor: '#d27b4b',
                        backgroundColor: 'rgba(210, 123, 75, 0.18)',
                        tension: 0.4,
                        borderWidth: 3,
                        fill: true,
                        pointRadius: 0,
                    },
                    {
                        label: 'Orders',
                        data: orders,
                        borderColor: '#c4a484',
                        backgroundColor: 'rgba(196, 164, 132, 0.18)',
                        tension: 0.4,
                        borderWidth: 3,
                        fill: true,
                        pointRadius: 0,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#2f1d1d',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        padding: 12,
                        cornerRadius: 12,
                    },
                },
                scales: {
                    x: { grid: { display: false }, ticks: { color: '#8c6f64' } },
                    y: { grid: { color: 'rgba(140, 111, 100, 0.12)' }, ticks: { color: '#8c6f64' } },
                },
            },
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('admin-tool-search');
        const results = document.getElementById('admin-tool-search-results');
        const button = document.getElementById('admin-tool-search-btn');
        const profileBtn = document.getElementById('admin-profile-btn');
        const profileMenu = document.getElementById('admin-profile-menu');
        const profileWrap = document.getElementById('admin-profile-wrap');

        // Search quick-jump
        if (input && results && button) {
            const tools = @json($adminTools);

            const renderResults = (query) => {
                const q = query.trim().toLowerCase();
                const matches = q
                    ? tools.filter(t => t.label.toLowerCase().includes(q)).slice(0, 6)
                    : [];

                if (!matches.length) {
                    results.classList.add('hidden');
                    results.innerHTML = '';
                    return;
                }

                results.innerHTML = matches.map(item => (
                    `<button type="button" class="w-full text-left px-4 py-3 hover:bg-brew-light-brown/10 transition rounded-lg flex items-center justify-between" data-url="${item.url}">
                        <span class="text-sm font-semibold text-brew-brown">${item.label}</span>
                        <svg class="w-4 h-4 text-brew-brown" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 5l7 7-7 7"></path></svg>
                    </button>`
                )).join('');

                results.classList.remove('hidden');
            };

            const navigateFirst = () => {
                const firstButton = results.querySelector('button');
                if (firstButton) {
                    window.location.href = firstButton.dataset.url;
                }
            };

            input.addEventListener('input', (e) => renderResults(e.target.value));
            input.addEventListener('focus', (e) => renderResults(e.target.value));
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    navigateFirst();
                }
                if (e.key === 'Escape') {
                    results.classList.add('hidden');
                }
            });

            button.addEventListener('click', navigateFirst);

            results.addEventListener('click', (e) => {
                const target = e.target.closest('button[data-url]');
                if (!target) return;
                window.location.href = target.dataset.url;
            });

            document.addEventListener('click', (e) => {
                if (!results.contains(e.target) && !input.contains(e.target) && !button.contains(e.target)) {
                    results.classList.add('hidden');
                }
            });
        }

        // Profile dropdown
        if (profileBtn && profileMenu && profileWrap) {
            const closeProfile = () => profileMenu.classList.add('hidden');

            profileBtn.addEventListener('click', () => {
                const isHidden = profileMenu.classList.contains('hidden');
                if (isHidden) {
                    profileMenu.classList.remove('hidden');
                    profileBtn.setAttribute('aria-expanded', 'true');
                } else {
                    closeProfile();
                    profileBtn.setAttribute('aria-expanded', 'false');
                }
            });

            document.addEventListener('click', (e) => {
                if (!profileWrap.contains(e.target)) {
                    closeProfile();
                    profileBtn.setAttribute('aria-expanded', 'false');
                }
            });

            profileMenu.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    closeProfile();
                    profileBtn.setAttribute('aria-expanded', 'false');
                }
            });
        }
    });
</script>