@extends('layouts.app')


@section('content')
<section class="section mt-3">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ $posts->title }}</h4>
        </div>
        <div class="card-body">
            {{ $posts->desc }}
        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function() {
            fetch("/farm-vehicle-statistics")
                .then(response => response.json())
                .then(data => {
                    // function generateTextLabelPlugin(fontSize, fontColor) {
                    //     return {
                    //         id: 'textLabelPlugin',
                    //         afterDatasetsDraw(chart) {
                    //             const {
                    //                 ctx,
                    //                 data
                    //             } = chart;

                    //             chart.data.datasets.forEach((dataset,
                    //                 datasetIndex) => { // Duyệt từng dataset (Hợp Đồng, Khách Hàng)
                    //                 chart.getDatasetMeta(datasetIndex).data.forEach((element,
                    //                     index) => {
                    //                     const value = dataset.data[
                    //                         index]; // Lấy giá trị của từng cột
                    //                     if (value > 0) { // Chỉ hiển thị số nếu giá trị > 0
                    //                         const {
                    //                             x,
                    //                             y
                    //                         } = element
                    //                             .getCenterPoint(); // Lấy vị trí chính giữa cột

                    //                         ctx.save();
                    //                         ctx.fillStyle = fontColor || '#fff';
                    //                         ctx.font = `${fontSize}px sans-serif`;
                    //                         ctx.textAlign = 'center';
                    //                         ctx.textBaseline = 'middle';
                    //                         ctx.fillText(value, x, y -
                    //                             10); // Vẽ số lên trên cột
                    //                         ctx.restore();
                    //                     }
                    //                 });
                    //             });
                    //         }
                    //     };
                    // }
                    const legendMargin = {
                        id: 'legendMargin',
                        beforeInit(chart, legend, options) {
                            let fitValue = chart.legend.fit;
                            chart.legend.fit = function fit() {
                                fitValue.bind(chart.legend)();
                                return this.height += options.paddingTop;
                            }
                        },
                        defaults: {
                            paddingTop: 0 // <-- default padding
                        }
                    };
                    // === Biểu đồ Xe & Nông Trường ===
                    // const months = Array.from(new Set([...data.farms.map(item => item.month), ...data.vehicles
                    //     .map(item => item.month)
                    // ])).sort((a, b) => a - b);

                    // const farmData = months.map(month => {
                    //     const item = data.farms.find(f => f.month == month);
                    //     return item ? item.total : 0;
                    // });

                    // const vehicleData = months.map(month => {
                    //     const item = data.vehicles.find(v => v.month == month);
                    //     return item ? item.total : 0;
                    // });

                    // const ctxFarmVehicle = document.getElementById("farmVehicleChart");
                    // if (ctxFarmVehicle) {
                    //     new Chart(ctxFarmVehicle, {
                    //         type: "bar",
                    //         data: {
                    //             labels: months.map(m => `Tháng ${m}`),
                    //             datasets: [{
                    //                     label: "Nông Trường",
                    //                     data: farmData,
                    //                     backgroundColor: "rgba(75, 192, 75, 0.6)",
                    //                     borderColor: "rgba(75, 192, 75, 1)",
                    //                     borderWidth: 1,
                    //                     barPercentage: 0.3,

                    //                 },
                    //                 {
                    //                     label: "Xe Vận Chuyển",
                    //                     data: vehicleData,
                    //                     backgroundColor: "rgba(255, 99, 132, 0.6)",
                    //                     borderColor: "rgba(255, 99, 132, 1)",
                    //                     borderWidth: 1,
                    //                     barPercentage: 0.3, // Điều chỉnh độ rộng cột

                    //                 }
                    //             ]
                    //         },
                    //         options: {
                    //             responsive: true,
                    //             scales: {
                    //                 x: {
                    //                     ticks: {
                    //                         font: {
                    //                             size: 16
                    //                         }
                    //                     }
                    //                 },
                    //                 y: {
                    //                     beginAtZero: true
                    //                 }
                    //             },
                    //             plugins: {
                    //                 legendMargin: { // <-- Set option of custom plugin
                    //                     paddingTop: 20 // <---- override the default value
                    //                 },
                    //                 legend: {
                    //                     onClick: (event) => {
                    //                         event.preventDefault(); // Chặn event click
                    //                     },
                    //                 },
                    //                 datalabels: {
                    //                     color: (context) => {
                    //                         return window.innerWidth <= 768 ? 'black' :
                    //                             'white';
                    //                     },
                    //                     anchor: (context) => {
                    //                         // Dynamically set anchor based on screen width
                    //                         return window.innerWidth <= 768 ? 'end' :
                    //                             'center'; // center on mobile
                    //                     },
                    //                     align: (context) => {
                    //                         // Dynamically set align based on screen width
                    //                         return window.innerWidth <= 768 ? 'top' :
                    //                             'center'; // center on mobile
                    //                     },
                    //                     font: {
                    //                         size: 14
                    //                     },
                    //                     offset: -2,
                    //                     formatter: (value) => {
                    //                         return Number(value) === 0 ? null : value;
                    //                     }

                    //                 }
                    //             },
                    //         },
                    //         // plugins: [generateTextLabelPlugin(14, '#fff')]
                    //         plugins: [legendMargin, ChartDataLabels]
                    //     });
                    // }



                    // === Biểu đồ Lô Hàng ===
                    const validBatches = data.batches.filter(item => item.month !== null);

                    const batchMonths = validBatches.map(item => item.month).sort((a, b) => a - b);

                    const totalBatches = batchMonths.map(month => {
                        const item = data.batches.find(b => b.month == month);
                        return item ? item.total_batches : 0;
                    });

                    const completedBatches = batchMonths.map(month => {
                        const item = data.batches.find(b => b.month == month);
                        return item ? item.completed_batches : 0;
                    });

                    const pendingBatches = batchMonths.map(month => {
                        const item = data.batches.find(b => b.month == month);
                        return item ? item.pending_batches : 0;
                    });
                    const isSingleBar = batchMonths.length === 1;

                    const ctxBatch = document.getElementById("batchChart");
                    if (ctxBatch) {
                        new Chart(ctxBatch, {
                            type: "bar",
                            data: {
                                labels: batchMonths.map(m => `Tháng ${m}`),
                                datasets: [{
                                        label: "Đã kiểm nghiệm",
                                        data: completedBatches,
                                        backgroundColor: "rgba(75, 192, 75, 0.6)",
                                        borderColor: "rgba(75, 192, 75, 1)",
                                        borderWidth: 1,
                                        barPercentage: isSingleBar ? 0.4 : 0.7,
                                        categoryPercentage: isSingleBar ? 0.5 : 0.8,
                                    },
                                    {
                                        label: "Chưa kiểm nghiệm",
                                        data: pendingBatches,
                                        backgroundColor: "rgba(178, 191, 199, 100)",
                                        borderColor: "rgba(178, 191, 199, 1)",
                                        borderWidth: 1,
                                        barPercentage: isSingleBar ? 0.4 : 0.7,
                                        categoryPercentage: isSingleBar ? 0.5 : 0.8,
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    x: {

                                        stacked: true, // ✅ gộp cột theo chiều ngang
                                        ticks: {
                                            font: {
                                                size: 16
                                            }
                                        }
                                    },
                                    y: {

                                        stacked: true, // ✅ gộp cột theo chiều dọc
                                        beginAtZero: true
                                    }
                                },
                                plugins: {
                                    legendMargin: { // <-- Set option of custom plugin
                                        paddingTop: 20 // <---- override the default value
                                    },
                                    legend: {
                                        onClick: (event) => {
                                            event.preventDefault();
                                        },
                                    },
                                    datalabels: {
                                        color: 'white',
                                        anchor: 'center',
                                        align: 'center',
                                        font: (context) => {
                                            return {
                                                size: window.innerWidth <= 768 ? 10 : 14
                                            };
                                        },
                                        offset: -2,
                                        formatter: (value) => {
                                            return Number(value) === 0 ? null : value;
                                        }
                                    }
                                },
                            },
                            // plugins: [generateTextLabelPlugin(14, '#fff')]
                            plugins: [legendMargin, ChartDataLabels]
                        });
                    }


                    // Hợp đồng - khách hàng
                    const contractCount = data.countContractWithCustomers.contracts;

                    const customerCount = data.countContractWithCustomers.customers;
                    const contractCustomer = document.getElementById("barChartContractCustomer");
                    if (contractCustomer) {
                        new Chart(contractCustomer, {
                            type: "bar",
                            data: {
                                labels: ["", ""], // 🔹 Gán labels rỗng để không hiển thị trên trục X
                                datasets: [{
                                        label: "Hợp Đồng",
                                        data: [contractCount, 0], // Chỉ có dữ liệu cho Hợp Đồng
                                        backgroundColor: "rgba(75, 192, 75, 0.6)",
                                        borderColor: "rgba(75, 192, 75, 1)",
                                        // borderWidth: 1,
                                        barPercentage: 5, // Điều chỉnh độ rộng cột (giá trị từ 0 đến 1)
                                        categoryPercentage: 0.1 // Điều chỉnh khoảng cách giữa các cột
                                    },
                                    {
                                        label: "Khách Hàng",
                                        data: [0, customerCount], // Chỉ có dữ liệu cho Khách Hàng
                                        backgroundColor: "rgba(255, 99, 132, 0.6)", // Đỏ hồng
                                        borderColor: "rgba(255, 99, 132, 1)",
                                        // borderWidth: 1,
                                        barPercentage: 5, // Điều chỉnh độ rộng cột (giá trị từ 0 đến 1)
                                        categoryPercentage: 0.1 // Điều chỉnh khoảng cách giữa các cột
                                    },
                                ],
                            },
                            options: {
                                responsive: true,
                                scales: {

                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            autoSkip: true, // Tự động bỏ bớt nếu có quá nhiều giá trị
                                        },
                                    }
                                },
                                plugins: {
                                    legendMargin: { // <-- Set option of custom plugin
                                        paddingTop: 20 // <---- override the default value
                                    },
                                    legend: {
                                        onClick: (event) => {
                                            event.preventDefault(); // Chặn event click
                                        },
                                    },
                                    datalabels: {
                                        color: (context) => {
                                            return window.innerWidth <= 768 ? 'black' :
                                                'white';
                                        },
                                        anchor: (context) => {
                                            // Dynamically set anchor based on screen width
                                            return window.innerWidth <= 768 ? 'end' :
                                                'center'; // center on mobile
                                        },
                                        align: (context) => {
                                            // Dynamically set align based on screen width
                                            return window.innerWidth <= 768 ? 'top' :
                                                'center'; // center on mobile
                                        },
                                        font: {
                                            size: 14
                                        },
                                        offset: -2,
                                        formatter: (value) => {
                                            return Number(value) === 0 ? null : value;
                                        }

                                    }
                                },
                            },
                            // plugins: [generateTextLabelPlugin(14, '#fff'), ]
                            plugins: [legendMargin, ChartDataLabels]
                        });
                    }

                    // === Biểu đồ số chuyến theo loại mủ từ từng nông trường ===
                    const results = data.countTripByTypeOfPusFromPlantation.results;

                    // Gom dữ liệu: { [farm_name]: { [name_pus]: total_trip } }
                    const groupedData = {};
                    results.forEach(item => {
                        const farm = item.farm_code;
                        const pus = item.name_pus;
                        const total = item.total_pus;

                        if (!groupedData[farm]) {
                            groupedData[farm] = {};
                        }
                        groupedData[farm][pus] = total;
                    });
                    // Lấy danh sách nông trường
                    const farmNames = Object.keys(groupedData);
                    // Hàm tạo màu ngẫu nhiên dạng rgba
                    function getColorMap(pusNames, opacity = 0.7) {
                        const baseColors = [
                            `rgba(75, 192, 75, ${opacity})`,
                            `rgba(255, 159, 64, ${opacity})`,
                            `rgba(255, 99, 132, ${opacity})`,
                            `rgba(54, 162, 235, ${opacity})`,
                            `rgba(255, 205, 86, ${opacity})`,
                            `rgba(153, 102, 255, ${opacity})`,
                            `rgba(100, 200, 100, ${opacity})`,
                            `rgba(201, 203, 207, ${opacity})`,
                        ];

                        const map = {};
                        let colorIndex = 0;
                        pusNames.forEach(pus => {
                            map[pus] = baseColors[colorIndex] || getRandomColor(opacity);
                            colorIndex++;
                        });

                        return map;
                    }


                    function getRandomColor(opacity = 0.7) {
                        const min = 60;
                        const max = 200;
                        const r = Math.floor(Math.random() * (max - min + 1)) + min;
                        const g = Math.floor(Math.random() * (max - min + 1)) + min;
                        const b = Math.floor(Math.random() * (max - min + 1)) + min;
                        return `rgba(${r}, ${g}, ${b}, ${opacity})`;
                    }
                    // Lấy danh sách tất cả loại mủ (để đảm bảo đúng thứ tự cột)
                    const pusNames = [...new Set(results.map(item => item.name_pus))];
                    const colorMap = getColorMap(pusNames);
                    // Xóa cache giữ cố định 1 màu cho các loại mủ
                    localStorage.removeItem('pusColorMap');

                    // Tạo datasets cho từng loại mủ
                    const datasets = pusNames.map(pus => {
                        return {
                            label: pus,
                            data: farmNames.map(farm => groupedData[farm][pus] || 0),
                            backgroundColor: colorMap[pus] || 'rgba(201, 203, 207, 0.7)',

                        };
                    });

                    let chartInstance = null;


                    function createChart() {
                        const ctxTrips = document.getElementById("tripTypeOfPusPlantationChart");

                        if (ctxTrips) {
                            const isMobile = window.innerWidth <= 768; // Kiểm tra kích thước màn hình
                            const isSingleFarm = farmNames.length === 1;

                            if (isMobile) {
                                ctxTrips.height = isSingleFarm ? 150 : farmNames.length * 80;
                            } else {
                                ctxTrips.height = isSingleFarm ? 200 : 200;
                            }

                            const indexAxis = isMobile ? 'y' : 'x';

                            const scales = {
                                x: {
                                    stacked: true,
                                    ...(indexAxis === 'x' && {
                                        title: {
                                            display: true,
                                            text: 'Nông Trường - Đơn vị',
                                            font: {
                                                weight: 'bold',
                                                size: isMobile ? 10 : 14
                                            }
                                        }
                                    })
                                },
                                y: {
                                    stacked: true,
                                    beginAtZero: true,
                                    ...(indexAxis === 'y' && {
                                        title: {
                                            display: true,
                                            text: 'Nông Trường - Đơn vị',
                                            font: {
                                                weight: 'bold',
                                                size: isMobile ? 10 : 14
                                            }
                                        }
                                    })
                                }
                            };
                            if (chartInstance) {
                                chartInstance.destroy();
                            }
                            chartInstance = new Chart(ctxTrips, {
                                type: "bar",
                                data: {
                                    labels: farmNames,
                                    datasets: datasets,
                                },
                                options: {
                                    responsive: true,
                                    scales: scales,
                                    indexAxis: indexAxis,
                                    elements: {
                                        bar: {
                                            maxBarThickness: isSingleFarm ? 30 : 60
                                        }
                                    },
                                    plugins: {
                                        legendMargin: { // <-- Set option of custom plugin
                                            paddingTop: 20 // <---- override the default value
                                        },
                                        legend: {
                                            onClick: (event) => {
                                                event.preventDefault();
                                            },
                                        },
                                        datalabels: {
                                            color: 'white',
                                            anchor: 'center',
                                            align: 'center',
                                            font: (context) => {
                                                return {
                                                    size: window.innerWidth <= 768 ? 10 : 12
                                                };
                                            },

                                            offset: -2,
                                            formatter: (value) => {
                                                return Number(value) === 0 ? null : value;
                                            }
                                        },
                                        tooltip: {
                                            mode: 'index',
                                            // intersect: false,

                                        },
                                    },
                                    categoryPercentage: isSingleFarm ? 0.4 : 0.7,
                                    barPercentage: isSingleFarm ? 0.5 : 0.8,
                                },
                                // plugins: [generateTextLabelPlugin(14, '#fff')]
                                plugins: [legendMargin, ChartDataLabels]
                            });
                            // Kiểm tra nếu biểu đồ đã tồn tại, hủy bỏ nó trước khi tạo mới

                        }
                    }

                    const chartContainer = document.getElementById("tripTypeOfPusPlantationChart");

                    // Hàm debounce
                    function debounce(func, wait = 200) {
                        let timeout;
                        return function(...args) {
                            clearTimeout(timeout);
                            timeout = setTimeout(() => func.apply(this, args), wait);
                        };
                    }

                    // Tạo biểu đồ ban đầu
                    createChart();

                    // Debounce resize window, tránh gọi liên tục
                    const debouncedCreateChart = debounce(createChart, 300);
                    window.addEventListener('resize', debouncedCreateChart);

                    // === Biểu đồ danh sách lô hàng ===
                    const totalBatche = data.countBatchesCreateConnect.totalBatches;
                    const linkedBatches = data.countBatchesCreateConnect.linkedBatches;
                    const createConnectBatches = document.getElementById("listbatchChart");
                    if (createConnectBatches) {
                        new Chart(createConnectBatches, {
                            type: "bar",
                            data: {
                                labels: ["", ""], // 🔹 Gán labels rỗng để không hiển thị trên trục X
                                datasets: [{
                                        label: "Đã tạo",
                                        data: [totalBatche, 0], // Chỉ có dữ liệu cho Hợp Đồng
                                        backgroundColor: "rgba(75, 192, 75, 0.6)",
                                        borderColor: "rgba(75, 192, 75, 1)",
                                        // borderWidth: 1,
                                        barPercentage: 5, // Điều chỉnh độ rộng cột (giá trị từ 0 đến 1)
                                        categoryPercentage: 0.1 // Điều chỉnh khoảng cách giữa các cột
                                    },
                                    {
                                        label: "Đã liên kết",
                                        data: [0,
                                            linkedBatches
                                        ], // Chỉ có dữ liệu cho Khách Hàng
                                        backgroundColor: "rgba(255, 99, 132, 0.6)", // Đỏ hồng
                                        borderColor: "rgba(255, 99, 132, 1)",
                                        // borderWidth: 1,
                                        barPercentage: 5, // Điều chỉnh độ rộng cột (giá trị từ 0 đến 1)
                                        categoryPercentage: 0.1 // Điều chỉnh khoảng cách giữa các cột
                                    },
                                ],
                            },
                            options: {
                                responsive: true,
                                scales: {

                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            autoSkip: true, // Tự động bỏ bớt nếu có quá nhiều giá trị
                                        },
                                    }
                                },
                                plugins: {
                                    legendMargin: { // <-- Set option of custom plugin
                                        paddingTop: 20 // <---- override the default value
                                    },
                                    legend: {
                                        onClick: (event) => {
                                            event.preventDefault(); // Chặn event click
                                        },
                                    },
                                    datalabels: {
                                        color: (context) => {
                                            return window.innerWidth <= 768 ? 'black' :
                                                'white';
                                        },
                                        anchor: (context) => {
                                            // Dynamically set anchor based on screen width
                                            return window.innerWidth <= 768 ? 'end' :
                                                'center'; // center on mobile
                                        },
                                        align: (context) => {
                                            // Dynamically set align based on screen width
                                            return window.innerWidth <= 768 ? 'top' :
                                                'center'; // center on mobile
                                        },
                                        font: {
                                            size: 14
                                        },
                                        offset: -2,
                                        formatter: (value) => {
                                            return Number(value) === 0 ? null : value;
                                        }

                                    }
                                },
                            },
                            // plugins: [generateTextLabelPlugin(14, '#fff'), ]
                            plugins: [legendMargin, ChartDataLabels]
                        });
                    }

                });

        });
</script>
{{-- @hasanyrole('Admin|Nông Trường|Xem Nông Trường')
<div class="card">
    <div class="card-header">
        <div class="card-body">
            <h4 style="text-align: center">Biểu đồ Xe và Nông Trường</h4>
            <canvas id="farmVehicleChart"></canvas>
        </div>
    </div>
</div>
@endhasanyrole --}}
@hasanyrole('Admin|Nông Trường|Danh Sách Nông Trường')
<div class="card">
    <div class="card-header">
        <div class="card-body">
            <h4 style="text-align: center">Biểu Đồ Loại Mủ Theo Từng Nông Trường</h4>
            <canvas id="tripTypeOfPusPlantationChart"></canvas>
        </div>
    </div>
</div>
@endhasanyrole
@hasanyrole('Nhà Máy XNCB|Admin|Danh Sách Nhà Máy|Quản Lý Nhà Máy')
<div class="card">
    <div class="card-header">
        <div class="card-body">
            <h4 style="text-align: center">Biểu Đồ Danh Sách Lô Hàng</h4>
            <canvas id="listbatchChart"></canvas>
        </div>
    </div>
</div>
@endhasanyrole

{{-- @hasanyrole('Nhà Máy|Admin|Xem Nhà Máy')
<div class="card">
    <div class="card-header">
        <div class="card-body">
            <h4 style="text-align: center">Biểu đồ Lô Hàng</h4>
            <canvas id="batchChart"></canvas>
        </div>
    </div>
</div>
@endhasanyrole --}}
@hasanyrole('Danh Sách Quản Lý Chất Lượng|Admin|Quản Lý Chất Lượng')
<div class="card">
    <div class="card-header">
        <div class="card-body">
            <h4 style="text-align: center">Biểu Đồ Lô Hàng</h4>
            <canvas id="batchChart"></canvas>
        </div>
    </div>
</div>
@endhasanyrole
@hasanyrole('Admin|Danh Sách Hợp Đồng|Quản Lý Hợp Đồng')
<div class="card">
    <div class="card-header">
        <div class="card-body">
            <h4 style="text-align: center">Biểu đồ Hợp Đồng và Khách Hàng</h4>
            <canvas id="barChartContractCustomer"></canvas>
        </div>
    </div>
</div>
@endhasanyrole
@endsection