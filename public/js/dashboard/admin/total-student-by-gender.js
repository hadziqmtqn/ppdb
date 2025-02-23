'use strict';

(function () {
    let cardColor, bodyColor;

    if (isDarkStyle) {
        cardColor = config.colors_dark.cardColor;
        bodyColor = config.colors_dark.bodyColor;
    } else {
        cardColor = config.colors.cardColor;
        bodyColor = config.colors.bodyColor;
    }

    const chartColors = {
        donut: {
            series1: config.colors.warning,
            series2: '#fdb528cc',
            series3: '#fdb52899',
            series4: '#fdb52866',
            series5: config.colors_label.warning
        }
    };

    let studentByGenderChart; // Variable to store the chart instance

    // Function to render the chart
    function renderChart(malePercentage, femalePercentage) {
        const studentByGenderChartEl = document.querySelector('#studentByGenderChart');
        const studentByGenderChartConfig = {
            chart: {
                height: 127,
                parentHeightOffset: 0,
                type: 'donut'
            },
            labels: ['L', 'P'],
            series: [malePercentage, femalePercentage], // Data from the response
            colors: [config.colors.primary, config.colors.secondary],
            stroke: {
                width: 5,
                colors: cardColor
            },
            tooltip: {
                y: {
                    formatter: function (val, opt) {
                        return val.toFixed(0) + '%';
                    }
                }
            },
            dataLabels: {
                enabled: false,
                formatter: function (val, opt) {
                    return val.toFixed(0) + '%';
                }
            },
            states: {
                hover: {
                    filter: { type: 'none' }
                },
                active: {
                    filter: { type: 'none' }
                }
            },
            legend: {
                show: false
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%',
                        labels: {
                            show: true,
                            value: {
                                fontSize: '1rem',
                                fontFamily: 'Inter',
                                color: bodyColor,
                                fontWeight: 500,
                                offsetY: 4,
                                formatter: function (val) {
                                    return val.toFixed(0) + '%';
                                }
                            },
                            name: {
                                show: false
                            },
                            total: {
                                show: true,
                                fontSize: '1.5rem',
                                fontWeight: 500,
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0).toFixed(0) + '%';
                                }
                            }
                        }
                    }
                }
            }
        };

        if (studentByGenderChartEl !== undefined && studentByGenderChartEl !== null) {
            if (studentByGenderChart) {
                studentByGenderChart.destroy(); // Destroy the existing chart instance
            }
            studentByGenderChart = new ApexCharts(studentByGenderChartEl, studentByGenderChartConfig);
            studentByGenderChart.render();
        }
    }

    const schoolYear = $('#select-school-year');
    const educationalInstitution = $('#select-educational-institution');

    // Function to fetch and render chart data
    function fetchAndRenderChart(schoolYearId, educationalInstitutionId) {
        axios.get('/student-by-gender', {
            params: {
                school_year_id: schoolYearId,
                educational_institution_id: educationalInstitutionId
            }
        })
            .then(function (response) {
                const data = response.data.data;
                const malePercentage = data.malePercentage;
                const femalePercentage = data.femalePercentage;

                // Update the total student count
                document.getElementById('totalStudentByGender').textContent = data.totalStudent;

                // Render the chart with the fetched data
                renderChart(malePercentage, femalePercentage);
            })
            .catch(function (error) {
                console.error('Error fetching student data:', error);
            });
    }

    // Fetch and render chart data on page load
    fetchAndRenderChart(schoolYear.val(), educationalInstitution.val());

    // Fetch and render chart data when school year or educational institution select changes
    schoolYear.on('change', function () {
        fetchAndRenderChart(schoolYear.val(), educationalInstitution.val());
    });

    educationalInstitution.on('change', function () {
        fetchAndRenderChart(schoolYear.val(), educationalInstitution.val());
    });
})();