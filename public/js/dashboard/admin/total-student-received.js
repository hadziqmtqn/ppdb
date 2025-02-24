(function () {
    let labelColor,
        headingColor,
        borderColor;

    if (typeof config !== 'undefined' && config.colors_dark) {
        labelColor = config.colors_dark.textMuted;
        headingColor = config.colors_dark.headingColor;
        borderColor = config.colors_dark.borderColor;
    } else {
        labelColor = config.colors.textMuted;
        headingColor = config.colors.headingColor;
        borderColor = config.colors.borderColor;
    }

    const salesCountryChartEl = document.querySelector('#studentReceivedChart');

    // Function to initialize chart with data
    function initializeChart(data) {
        const salesCountryChartConfig = {
            chart: {
                type: 'bar',
                height: 368,
                parentHeightOffset: 0,
                toolbar: {
                    show: false
                }
            },
            series: data.series,
            plotOptions: {
                bar: {
                    borderRadius: 10,
                    barHeight: '60%',
                    horizontal: true,
                    distributed: true,
                    startingShape: 'rounded',
                    dataLabels: {
                        position: 'bottom'
                    }
                }
            },
            dataLabels: {
                enabled: true,
                textAnchor: 'start',
                offsetY: 8,
                offsetX: 11,
                style: {
                    fontWeight: 500,
                    fontSize: '0.9375rem',
                    fontFamily: 'Inter'
                }
            },
            tooltip: {
                enabled: false
            },
            legend: {
                show: false
            },
            colors: data.colors,
            grid: {
                strokeDashArray: 8,
                borderColor,
                xaxis: { lines: { show: true } },
                yaxis: { lines: { show: false } },
                padding: {
                    top: -18,
                    left: 21,
                    right: 33,
                    bottom: 10
                }
            },
            xaxis: {
                categories: data.categories,
                labels: {
                    formatter: function (val) {
                        return Number(val);
                    },
                    style: {
                        fontSize: '0.9375rem',
                        colors: labelColor,
                        fontFamily: 'Inter'
                    }
                },
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                }
            },
            yaxis: {
                labels: {
                    style: {
                        fontWeight: 500,
                        fontSize: '0.9375rem',
                        colors: headingColor,
                        fontFamily: 'Inter'
                    }
                }
            },
            states: {
                hover: {
                    filter: {
                        type: 'none'
                    }
                },
                active: {
                    filter: {
                        type: 'none'
                    }
                }
            }
        };

        if (typeof salesCountryChartEl !== undefined && salesCountryChartEl !== null) {
            const salesCountryChart = new ApexCharts(salesCountryChartEl, salesCountryChartConfig);
            salesCountryChart.render();
        }
    }

    // Fetch data from endpoint
    fetch('/total-student-received')
        .then(response => response.json())
        .then(responseData => {
            if (responseData.success) {
                const data = responseData.data;
                const categories = [];
                const series = [];
                const colors = [];

                // Extract unique educational institution names and assign colors
                const institutionNames = [];
                Object.keys(data).forEach(key => {
                    data[key].educationalInstitutions.forEach(institution => {
                        if (!institutionNames.includes(institution.name)) {
                            institutionNames.push(institution.name);
                            series.push({ name: institution.name, data: [], color: config.colors[institution.color] });
                            colors.push(config.colors[institution.color]);
                        }
                    });
                });

                // Fill series data
                Object.keys(data).forEach(key => {
                    categories.push(data[key].year);
                    data[key].educationalInstitutions.forEach(institution => {
                        const seriesIndex = series.findIndex(item => item.name === institution.name);
                        if (seriesIndex !== -1) {
                            series[seriesIndex].data.push(institution.total);
                        }
                    });
                });

                initializeChart({ categories, series, colors });
            }
        })
        .catch(error => console.error('Error fetching data:', error));
})();