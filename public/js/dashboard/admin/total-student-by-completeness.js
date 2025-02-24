'use strict';

(function () {
    let headingColor;

    if (isDarkStyle) {
        headingColor = config.colors_dark.headingColor;
    } else {
        headingColor = config.colors.headingColor;
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

    let studentByCompletenessChart; // Variable to store the chart instance

    // Function to render the chart
    function renderChart(completed, incompleted) {
        const studentByCompletenessChartEl = document.querySelector('#studentByCompletenessChart');
        const studentByCompletenessChartConfig = {
            chart: {
                height: 134,
                type: 'radialBar',
                sparkline: {
                    enabled: true
                }
            },
            plotOptions: {
                radialBar: {
                    hollow: {
                        size: '55%'
                    },
                    dataLabels: {
                        name: {
                            show: false
                        },
                        value: {
                            show: true,
                            offsetY: 5,
                            fontWeight: 500,
                            fontSize: '1rem',
                            fontFamily: 'Inter',
                            color: headingColor
                        }
                    },
                    track: {
                        background: config.colors_label.secondary
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
            },
            stroke: {
                lineCap: 'round'
            },
            colors: [config.colors.primary],
            grid: {
                padding: {
                    bottom: -15
                }
            },
            series: [completed],
            labels: ['Progress']
        };

        if (studentByCompletenessChartEl !== undefined && studentByCompletenessChartEl !== null) {
            if (studentByCompletenessChart) {
                studentByCompletenessChart.destroy(); // Destroy the existing chart instance
            }
            studentByCompletenessChart = new ApexCharts(studentByCompletenessChartEl, studentByCompletenessChartConfig);
            studentByCompletenessChart.render();
        }
    }

    const schoolYear = $('#select-school-year');
    const educationalInstitution = $('#select-educational-institution');

    // Function to fetch and render chart data
    function fetchAndRenderChart(schoolYearId, educationalInstitutionId) {
        axios.get('/student-by-data-completeness', {
            params: {
                school_year_id: schoolYearId,
                educational_institution_id: educationalInstitutionId
            }
        })
            .then(function (response) {
                const data = response.data.data;
                const completed = data.completedData.completed.percentage;
                const incompleted = data.completedData.incomplete.percentage;

                // Render the chart with the fetched data
                renderChart(completed, incompleted);
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