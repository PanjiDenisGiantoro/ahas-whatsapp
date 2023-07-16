<x-layout-dashboard title="Home">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <div class="app-content" style="margin-top: 0;">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <h5 style="opacity: 0;" class="nav-link text-mt-1 hide-sidebar-toggle-button">Status Langganan : {{Auth::user()->expired_subscription}}</h5>
                    <div class="col-xl-4">
                        <div class="card widget widget-stats">
                            <div class="card-body">

                                <div class="widget-stats-container d-flex">

                                    <div class="widget-stats-icon widget-stats-icon-primary">
                                        <i class="fa fa-whatsapp"></i>
                                    </div> 

                                    <div class="widget-stats-content flex-fill">

                                        <span class="widget-stats-title">Perangkat Aktif : </span>

                                        <span class="widget-stats-amount"> <x-select-device></x-select-device> </span>

                                    </div> 

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">

                        <div class="card widget widget-stats">

                            <div class="card-body">

                                <div class="widget-stats-container d-flex">

                                    <div class="widget-stats-icon widget-stats-icon-primary">

                                        <i class="fa fa-users"></i>

                                    </div>

                                    <div class="widget-stats-content flex-fill">

                                        <span class="widget-stats-title">Semua Kontak</span>

                                        <span class="widget-stats-amount">{{ Auth::user()->contacts()->count()}}</span>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                    <div class="col-xl-4">

                        <div class="card widget widget-stats">

                            <div class="card-body">

                                <div class="widget-stats-container d-flex">

                                    <div class="widget-stats-icon widget-stats-icon-warning">

                                        <i class="fa fa-comment"></i>

                                    </div>

                                    <div class="widget-stats-content flex-fill">

                                        <span class="widget-stats-title">Pesan Masal</span>

                                        <span class="widget-stats-info">{{Auth::user()->blasts()->where(['status' => 'success'])->count()}} Sukses</span>

                                        <span class="widget-stats-info">{{Auth::user()->blasts()->where(['status' => 'failed'])->count()}} Gagal</span>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                    <div class="col-xl-8">
                        <div class="card widget widget-stats">
                            <div class="card-body">
                                <h3 class="mb-3">Data Pengguna Per Kabupaten/Kota</h3>
                                {{-- grafik --}}
                                <canvas id="myChart"></canvas>
                                <?php
                                    //Inisialisasi nilai variabel awal
                                    foreach ($users as $item)
                                    {
                                        $jur=$item->total_blast;
                                        $jurusan[] = $jur;
                                        $jum=$item->name;
                                        $jumlah[] = $jum;
                                    }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="card widget widget-stats">
                            <div class="card-body">
                                <h3 class="mb-3">Top 5 Blast Per Kabupaten/Kota</h3>
                                <div><canvas id="acquisitions"></canvas></div>
                                <?php
                                    //Inisialisasi nilai variabel awal
                                    foreach ($range as $items)
                                    {
                                        $jur=$items->total_blast;
                                        $ranges[] = $jur;
                                        $jum=$items->name;
                                        $total[] = $jum;
                                    }
                                ?>
                            </div>
                        </div>
                    </div>

                    @if(Auth::user()->level == 'admin')
                        <div class="col-xl-8">
                            <div class="card widget widget-stats">
                                <div class="card-body">
                                    <h3 class="mb-3">Data Terbanyak Blast</h3>
                                    <div class="table-responsive" >
                                        <table class="table" id="dataCari">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Ahas</th>
                                                    <th>Nomor Pengirim</th>
                                                    <th>Jumlah Blast</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($user_blasts as $no => $tem)
                                                    <tr>
                                                        <td>
                                                            {{$no+ 1}}
                                                        </td>
                                                        <td>
                                                            {{$tem->nama_ahas ?? ''}}
                                                        </td>
                                                        <td>
                                                            {{$tem->sender ?? ''}}
                                                        </td>
                                                        <td>
                                                            {{$tem->total ?? ''}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4">
                            <div class="card widget widget-stats">
                                <div class="card-body">
                                    <h3 class="mb-3">Top 5 Jenis Motor</h3>
                                    <div><canvas id="motorType"></canvas></div>
                                    <?php
                                        //Inisialisasi nilai variabel awal
                                        foreach ($motor_type as $items)
                                        {
                                            $desc=$items->deskripsi ?? '';
                                            $description[] = $desc;
                                            $totalMotor=$items->total;
                                            $total_motor[] = $totalMotor;
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="card widget widget-stats">
                                <div class="card-body">
                                    <h3 class="mb-3">Jenis Follow Up</h3>
                                    <div style="height: 400px; align-items: center; justify-content: center; align-content: center"><canvas id="Jenis"></canvas></div>
                                    <?php
                                        //Inisialisasi nilai variabel awal
                                        foreach ($jenis_data as $items)
                                        {
                                            $jenisData=$items->jenis_data ?? '';
                                            $jenisdata[] = $jenisData;
                                            $totalJenis=$items->total ?? '';
                                            $totaljenis[] = $totalJenis;
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="card widget widget-stats">
                                <div class="card-body">
                                    <h3 class="mb-3">Top 5 AHAS</h3>
                                    <div style="height: 400px; justify-content: center;">
                                        <canvas id="namaAhas"></canvas>
                                    </div>
                                    <?php
                                        //Inisialisasi nilai variabel awal
                                        foreach ($nama_ahas as $items)
                                        {
                                            $nama=$items->nama_ahas ?? '';
                                            $namaAhas[] = $nama;
                                            $total_ahas=$items->total ?? '';
                                            $totalAhas[] = $total_ahas;
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
        </div>
    </div>

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <script>

        var typingTimer;                //timer identifier
        var doneTypingInterval = 1000;
        $('#webhook').keydown(function(){
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function(){
                $.ajax({
                    method : 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

                    url : '{{route('setHook')}}',

                    data : {

                        number : $('#webhook').data('id'),

                        webhook : $('#webhook').val()

                    },
                    dataType : 'json',
                    
                    success : (result) => {},
                    error : (err) => {

                            console.log(err);

                    }
                })

            }, doneTypingInterval);

        })

        $(document).ready(function () {

            $('#example').DataTable();

        });

        function removeAlert() {

            $('#alert-beh').remove();

        }
    </script>

    <script>

        var ctx = document.getElementById('myChart').getContext('2d');

        var chart = new Chart(ctx, {

            // The type of chart we want to create

            type: 'bar',

            // The data for our dataset

            data: {

                labels: <?php echo json_encode($jumlah); ?>,

                datasets: [{

                    label:'Data Ahas Jawa Barat ',

                    backgroundColor: ['#B9EDDD', '#7C96AB', '#C7E9B0','#ABC4AA'],

                    borderColor: ['#B9EDDD', '#7C96AB', '#C7E9B0', '#ABC4AA'],

                    data: <?php echo json_encode($jurusan); ?>

                }]

            },

            // Configuration options go here

            options: {

                scales: {

                    yAxes: [{

                        ticks: {

                            beginAtZero:true

                        }

                    }]

                }

            }

        });

    </script>

    <script>

        var ctx = document.getElementById('acquisitions').getContext('2d');

        var chart = new Chart(ctx, {

            // The type of chart we want to create

            type: 'pie',

            // The data for our dataset

            data: {

                labels: <?php echo json_encode($total ?? ''); ?>,

                datasets: [{

                    label: '5 Data Ahas Sering Blast',

                    backgroundColor: ['#6096B4', '#AACB73', '#61876E'],

                    borderColor: ['#6096B4', '#AACB73', '#61876E'],

                    data: <?php echo json_encode($ranges ?? ''); ?>

                }]

            },

            // Configuration options go here

            options: {

                scales: {

                    yAxes: [{

                        ticks: {

                            beginAtZero:true

                        }

                    }]

                }

            }

        });

    </script>

    <script>

        var ctype = document.getElementById('motorType').getContext('2d');

        var chart = new Chart(ctype, {

            // The type of chart we want to create

            type: 'pie',

            // The data for our dataset

            data: {

                labels: <?php echo json_encode($description ?? ''); ?>,

                datasets: [{

                    label: '5 Data Ahas Sering Blast',

                    backgroundColor: ['#557153', '#6D9886', '#3C4048', '#256D85', '#D6CDA4'],

                    borderColor:['#557153', '#6D9886', '#3C4048', '#256D85', '#D6CDA4'],

                    data: <?php echo json_encode($total_motor ?? ''); ?>,
                    borderWidth: 1,
                }]

            },

            // Configuration options go here

            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

    </script>

    <script>

        var ctype = document.getElementById('Jenis').getContext('2d');

        var chart = new Chart(ctype, {

            // The type of chart we want to create

            type: 'pie',

            // The data for our dataset

            data: {

                labels: <?php echo json_encode($jenisdata ?? ''); ?>,

                datasets: [{

                    label: '5 Data Ahas Sering Blast',

                    backgroundColor: ['#6FEDD6', '#FFF38C', '#3FA796', '#256D85','#DF7861',],

                    borderColor:  ['#6FEDD6', '#FFF38C', '#3FA796', '#256D85','#DF7861',],

                    data: <?php echo json_encode($totaljenis ?? ''); ?>


                }]

            },

            // Configuration options go here
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

    </script>

    <script>

        var ctype = document.getElementById('namaAhas').getContext('2d');

        var chart = new Chart(ctype, {

            // The type of chart we want to create

            type: 'line',

            // The data for our dataset

            data: {

                labels: <?php echo json_encode($namaAhas ?? ''); ?>,

                datasets: [
                    {
                        type: 'line',
                        label: 'Top 5 AHAS',
                        data: <?php echo json_encode($totalAhas ?? ''); ?>
                    },
                ]

            },

            // Configuration options go here

            options: {

                scales: {

                    yAxes: [{

                        ticks: {

                            beginAtZero:true

                        }

                    }]

                }

            }
        });

    </script>



</x-layout-dashboard>