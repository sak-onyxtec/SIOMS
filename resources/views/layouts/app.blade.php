<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

     {{-- Font Awesome Icons --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous"
          referrerpolicy="no-referrer" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    @livewireStyles

    <style>
        [x-cloak] { display: none !important; }
    </style>

</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @if (Auth::user()->hasRole('customer'))
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        @else
            @include('layouts.navigation2')
        @endif
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    function initStyledDataTables(rootSelector) {
        const $root = rootSelector ? $(rootSelector) : $(document);

        $root.find('table.js-datatable').each(function () {
            const table = $(this);

            // If already initialized, destroy first so we can safely re-init with new HTML
            if ($.fn.DataTable.isDataTable(table)) {
                table.DataTable().destroy();
                table.removeData('dt-initialized');
            }

            // Preserve existing Tailwind styling while enabling DataTables + Bootstrap 5
            table.addClass('table table-hover align-middle mb-0');

            const dt = table.DataTable({
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                ordering: true,
                autoWidth: false,
                // Layout: length (left), filter (right) on first row
                dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6'f>>" +
                     "<'row'<'col-sm-12'tr>>" +
                     "<'row mt-2'<'col-sm-5'i><'col-sm-7'p>>",
                language: {
                    search: '',
                    searchPlaceholder: 'Search...',
                    lengthMenu: '_MENU_ per page'
                },
                initComplete: function () {
                    // Mark as initialized so we can skip redundant setup if needed
                    table.data('dt-initialized', true);
                },
                // Keep existing header alignment and spacing
                drawCallback: function () {
                    table.find('thead').addClass('bg-gradient-to-r from-blue-50 to-blue-100');
                    table.find('thead th').addClass('align-middle');

                    const wrapper = table.closest('.dataTables_wrapper');

                    // Bigger, styled search input
                    wrapper.find('.dataTables_filter input')
                        .addClass('form-control form-control-lg px-4 py-2 rounded-lg border border-gray-300 shadow-sm')
                        .css({ width: '320px', maxWidth: '100%' })
                        .attr('placeholder', 'Search...');

                    // Place search bar on the right
                    const filter = wrapper.find('.dataTables_filter');
                    filter.addClass('text-end');
                    filter.closest('.col-sm-6')
                        .addClass('text-end d-flex justify-content-end');

                    wrapper.find('.dataTables_filter label')
                        .addClass('flex items-center gap-2 text-gray-600 mb-2');

                    // Clean up default "Search:" text, keep only the input
                    wrapper.find('.dataTables_filter label').contents().filter(function () {
                        return this.nodeType === 3; // text node
                    }).remove();

                    // Extra column filters for inventory page
                    if (table.attr('id') === 'inventory-table') {
                        const api = this.api();

                        // Product filter (column index 4)
                        $('#inventory-filter-product').off('.dtInv').on('change.dtInv', function () {
                            const val = $(this).val();
                            api.column(4).search(val ? '^' + $.fn.dataTable.util.escapeRegex(val) + '$' : '', true, false).draw();
                        });

                        $('#inventory-filter-type').off('.dtInv').on('change.dtInv', function () {
                            const val = $(this).val();
                            api.column(1).search(val || '', false, false).draw();
                        });

                        
                    }
                    if(table.attr('id') === 'orders-table')
                    {
                        const api = this.api();
                        $('#orders-status-filter').off('.dtInv').on('change.dtInv', function () {
                            const val = $(this).val();
                            api.column(2).search(val || '', false, false).draw();
                        });
                    }
                }
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        initStyledDataTables();
    });

    document.addEventListener('livewire:load', function () {
        if (window.Livewire) {
            Livewire.hook('message.processed', (message, component) => {
                // Re-init DataTables safely inside the updated component
                initStyledDataTables(component.el);
            });

            // Explicit refresh from inventory Livewire component (after new transaction)
            Livewire.on('inventory-table-refresh', () => {
                initStyledDataTables('#inventory-table');
            });
        }
    });
</script>

@livewireScripts
@stack('scripts')

</html>
