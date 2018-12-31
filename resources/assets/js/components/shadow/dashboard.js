

if ($('body').find('#shadow-home').length > 0) {
    $(function () {


        const urlApi = '/api/v1/shadow/data-graphs/',
            urlPage = '/simdepad/shadow', placeRight = $('.place-right'),
            targetStudent = '.user-list-right', targetObj = $('#shadow-home'),
            targetFill=targetObj.children().eq(0),
            noticeEl=$('.not-found-notice,.error-notice'),
            loadMagnify= $('.loading'), not_found = $('.not-found-notice'),
            triggerRight = $('.trigger-right'),
            listLabel = ['Tertinggi', 'Terendah', 'Nilai Terakhir']
        ;
        var ctx = document.getElementById("graph").getContext('2d');
        let dataQ,
            getDataAsync = function () {
                const urlSide = 'get';
                loadMagnify.show();
                noticeEl.hide();
                targetFill.hide();

                if (placeRight.hasClass('activo')){
                    placeRight.removeClass('activo');
                    setTimeout(function (){
                        triggerRight.removeClass('non');
                    },300)
                }

                axios.get(urlApi + urlSide + '?key=' + dataQ.student_key)
                    .then(res => {
                        loadMagnify.hide();
                        targetFill.show();
                        let Dat = res.data, z = 0
                        ;

                        $('.user-list-right ').removeClass('activo');

                        placeRight.find('[data-key="'+dataQ.student_key+'"]').addClass('activo');

                        $.each($('.header-card-dash'),function (i,val) {
                            $(val).children('span').text(Dat.name);
                        });

                        config.data.labels = Dat.act_label;
                        config.data.datasets = [];
                        loopGrapRadar([Dat.max, Dat.min, Dat.last_score]);
                        myRadar.update();

                        $.each(Dat.date_label, function (i, val) {
                            lineData.data.labels.push(moment(val));
                        });

                        lineData.data.datasets=[];
                        $.each(Dat.list, function (i, val) {
                            lineData.data.datasets.push({
                                fillColor: "rgba(255,255,255,0)",
                                strokeColor: "rgba(16,133,135,1)",
                                pointStrokeColor: "#fff",
                                label: i,
                                backgroundColor: arColorChart[z].bg,
                                borderColor: arColorChart[z].border,
                                pointBackgroundColor: arColorChart[z].border,
                                fill: false,
                                data: [],
                                notes: [],
                                act: []
                            });
                            changeProper(val, lineData.data.datasets[z]);

                            z++;
                        });


                        setTimeout(function () {
                            myChart.update();
                            loadMagnify.hide();
                            targetFill.show();
                        }, 1000);


                    })
                    .catch(er => {
                        noticeListTable(er.response);
                    })
            },
            loopGrapRadar = function (dataN) {
                $.each(dataN, function (z, daT) {
                    config.data.datasets.push({
                        label: listLabel[z],
                        backgroundColor: arColorChart[z].bg,
                        borderColor: arColorChart[z].border,
                        pointBackgroundColor: arColorChart[z].border,
                        data: [],
                        notes: [],
                        act: []
                    });

                    changeProper(daT, config.data.datasets[z]);

                });
            },
            changeProper = function (datass, objN) {
                let score_pick = [], date_pick = [], achiv_pick = [], note_pick = [], act_pick = [];
                $.each(datass, function (i, val) {
                    score_pick.push(val.value);
                    date_pick.push(val.date);
                    achiv_pick.push(val.achievement);
                    note_pick.push(val.note);
                    act_pick.push(val.activity_sub);
                });
                objN.data = score_pick;
                objN.notes = note_pick;
                objN.achivs = achiv_pick;
                objN.acts = act_pick;
                objN.dats = date_pick;
            }
        ;

        let lineData = {type: 'line',
            data:{},
            options: {
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                legend: {
                    display: true,
                    position: 'bottom'

                },
                scales: {
                    yAxes: [{
                        ticks: {
                            suggestedMin: 0,
                            suggestedMax: 4
                        }
                    }],
                    xAxes: [{
                        type: 'time',
                        distribution: 'linear',
                        time: {
                            displayFormats: {
                                // 'millisecond': 'MMM DD',
                                // 'second': 'MMM DD',
                                // 'minute': 'MMM DD',
                                'hour': 'MMM DD',
                                'day': 'MMM DD',
                                'week': 'MMM DD',
                                'month': 'MMM DD',
                                'quarter': 'MMM DD',
                                'year': 'MMM DD',
                            }
                        },
                        /* ticks: {
                             callback: function(value) {
                                 return new Date(value).toLocaleDateString('id', {month:'short', year:'numeric'});
                             },
                         },*/
                        // scaleLabel: {
                        //     display: true,
                        //     labelString: 'Date'
                        // }
                    }],
                },
                tooltips: {
                    enabled: false,
                    callbacks: {
                        label: function (tooltipItem, data) {
                            var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                            //This will be the tooltip.body
                            return datasetLabel + ': ' + tooltipItem.yLabel + '<br>Kegiatan: ' +
                                data.datasets[tooltipItem.datasetIndex].acts[tooltipItem.index] + '<br>Kemajuan: ' +
                                data.datasets[tooltipItem.datasetIndex].achivs[tooltipItem.index] + '<br>Catatan: ' +
                                data.datasets[tooltipItem.datasetIndex].notes[tooltipItem.index];
                        }
                    },
                    custom: function (tooltip) {
                        // Tooltip Element
                        var tooltipEl = document.getElementById('chartjs-tooltip');
                        if (!tooltipEl) {
                            tooltipEl = document.createElement('div');
                            tooltipEl.id = 'chartjs-tooltip';
                            tooltipEl.innerHTML = "<table></table>";
                            document.body.appendChild(tooltipEl);
                        }
                        // Hide if no tooltip
                        if (tooltip.opacity === 0) {
                            tooltipEl.style.opacity = 0;
                            return;
                        }
                        // Set caret Position
                        tooltipEl.classList.remove('above', 'below', 'no-transform');
                        if (tooltip.yAlign) {
                            tooltipEl.classList.add(tooltip.yAlign);
                        } else {
                            tooltipEl.classList.add('no-transform');
                        }

                        function getBody(bodyItem) {
                            return bodyItem.lines;
                        }

                        // Set Text
                        if (tooltip.body) {
                            var titleLines = tooltip.title || [];
                            var bodyLines = tooltip.body.map(getBody);
                            var innerHtml = '<thead>';
                            titleLines.forEach(function (title) {
                                innerHtml += '<tr><th>' + title + '</th></tr>';
                            });
                            innerHtml += '</thead><tbody>';
                            bodyLines.forEach(function (body, i) {
                                var colors = tooltip.labelColors[i];
                                var style = 'background:' + colors.backgroundColor;
                                style += '; border-color:' + colors.borderColor;
                                style += '; border-width: 2px';
                                var span = '<span class="chartjs-tooltip-key" style="' + style + '"></span>';
                                innerHtml += '<tr><td>' + span + body + '</td></tr>';
                            });
                            innerHtml += '</tbody>';
                            var tableRoot = tooltipEl.querySelector('table');
                            tableRoot.innerHTML = innerHtml;
                        }
                        var position = this._chart.canvas.getBoundingClientRect();
                        // Display, position, and set styles for font
                        tooltipEl.style.opacity = 1;
                        tooltipEl.style.left = position.left + tooltip.caretX + 'px';
                        tooltipEl.style.top = position.top + tooltip.caretY + 'px';
                        tooltipEl.style.fontFamily = tooltip._fontFamily;
                        tooltipEl.style.fontSize = tooltip.fontSize;
                        tooltipEl.style.fontStyle = tooltip._fontStyle;
                        tooltipEl.style.padding = tooltip.yPadding + 'px ' + tooltip.xPadding + 'px';
                        tooltipEl.style.maxWidth = '30em';
                        tooltipEl.style.minWidth = '15em';
                        tooltipEl.style.zIndex = 2;
                    }
                }

            }};



        $(document).ready(function () {
            $('.content-up').css('padding-bottom','3em');
            let Student = placeRight.find(targetStudent);
            $('.user-list-right').parent().css('padding', 0).css('border-top', '1px dashed #eee');
            if (Student.length > 0) {
                dataQ = {
                    student_key: getUrlParameter('student') ? getUrlParameter('student') : (Student.eq(0).data('key') ? Student.eq(0).data('key') : null),
                };
                getDataAsync();
            } else {
                targetObj.eq(0).hide();
                not_found.show();
            }
        });


        var config = {
            type: 'radar',
            data: {},
            options: {
                legend: {
                    position: 'bottom',
                },
                scale: {
                    ticks: {
                        beginAtZero: true
                    }
                },
                tooltips: {
                    enabled: false,
                    callbacks: {
                        label: function (tooltipItem, data) {
                            var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                            //This will be the tooltip.body
                            return datasetLabel + ': ' + tooltipItem.yLabel + '<br>Kegiatan: ' +
                                data.datasets[tooltipItem.datasetIndex].acts[tooltipItem.index] + '<br>Kemajuan: ' +
                                data.datasets[tooltipItem.datasetIndex].achivs[tooltipItem.index] + '<br>Catatan: ' +
                                data.datasets[tooltipItem.datasetIndex].notes[tooltipItem.index] + '<br>Tanggal: ' +
                                moment(data.datasets[tooltipItem.datasetIndex].dats[tooltipItem.index]).format('DD MMM YY');
                        }
                    },
                    custom: function (tooltip) {
                        // Tooltip Element
                        var tooltipEl = document.getElementById('chartjs-tooltip');
                        if (!tooltipEl) {
                            tooltipEl = document.createElement('div');
                            tooltipEl.id = 'chartjs-tooltip';
                            tooltipEl.innerHTML = "<table></table>";
                            document.body.appendChild(tooltipEl);
                        }
                        // Hide if no tooltip
                        if (tooltip.opacity === 0) {
                            tooltipEl.style.opacity = 0;
                            return;
                        }
                        // Set caret Position
                        tooltipEl.classList.remove('above', 'below', 'no-transform');
                        if (tooltip.yAlign) {
                            tooltipEl.classList.add(tooltip.yAlign);
                        } else {
                            tooltipEl.classList.add('no-transform');
                        }

                        function getBody(bodyItem) {
                            return bodyItem.lines;
                        }

                        // Set Text
                        if (tooltip.body) {
                            var titleLines = tooltip.title || [];
                            var bodyLines = tooltip.body.map(getBody);
                            var innerHtml = '<thead>';
                            titleLines.forEach(function (title) {
                                innerHtml += '<tr><th>' + title + '</th></tr>';
                            });
                            innerHtml += '</thead><tbody>';
                            bodyLines.forEach(function (body, i) {
                                var colors = tooltip.labelColors[i];
                                var style = 'background:' + colors.backgroundColor;
                                style += '; border-color:' + colors.borderColor;
                                style += '; border-width: 2px';
                                var span = '<span class="chartjs-tooltip-key" style="' + style + '"></span>';
                                innerHtml += '<tr><td>' + span + body + '</td></tr>';
                            });
                            innerHtml += '</tbody>';
                            var tableRoot = tooltipEl.querySelector('table');
                            tableRoot.innerHTML = innerHtml;
                        }
                        var position = this._chart.canvas.getBoundingClientRect();
                        // Display, position, and set styles for font
                        tooltipEl.style.opacity = 1;
                        tooltipEl.style.left = position.left + tooltip.caretX + 'px';
                        tooltipEl.style.top = position.top + tooltip.caretY + 400 + 'px';
                        tooltipEl.style.fontFamily = tooltip._fontFamily;
                        tooltipEl.style.fontSize = tooltip.fontSize;
                        tooltipEl.style.fontStyle = tooltip._fontStyle;
                        tooltipEl.style.padding = tooltip.yPadding + 'px ' + tooltip.xPadding + 'px';
                        tooltipEl.style.maxWidth = '30em';
                        tooltipEl.style.minWidth = '15em';
                        tooltipEl.style.zIndex = 2;
                    }
                }
            }
        };

        placeRight.on('click',targetStudent,function () {
            dataQ.student_key=$(this).data('key');
            getDataAsync();
        });

        $('.fa-times').click(function () {
            $(this).parent().fadeOut(300).next().fadeOut(300);
        });

        var myRadar = new Chart(document.getElementById("canvas"), config);
        var myChart = new Chart(ctx, lineData);


    });
}


if ($('body').find('#shadow-home').length > 0) {
    $(function () {


        const urlApi = '/api/v1/shadow/data-graphs/',
            urlPage = '/simdepad/shadow', placeRight = $('.place-right'),
            targetStudent = '.user-list-right', targetObj = $('#shadow-home'),
            targetFill=targetObj.children().eq(0),
            noticeEl=$('.not-found-notice,.error-notice'),
            loadMagnify= $('.loading'), not_found = 'not-found-notice',
            triggerRight = $('.trigger-right'),
            listLabel = ['Tertinggi', 'Terendah', 'Nilai Terakhir']
        ;
        var ctx = document.getElementById("graph").getContext('2d');
        let dataQ,
            getDataAsync = function () {
                const urlSide = 'get';
                loadMagnify.show();
                noticeEl.hide();
                targetFill.hide();

                if (placeRight.hasClass('activo')){
                    placeRight.removeClass('activo');
                    setTimeout(function (){
                        triggerRight.removeClass('non');
                    },300)
                }

                axios.get(urlApi + urlSide + '?key=' + dataQ.student_key)
                    .then(res => {
                        let Dat = res.data, z = 0
                        ;

                        $('.user-list-right ').removeClass('activo');

                        placeRight.find('[data-key="'+dataQ.student_key+'"]').addClass('activo');

                        $.each($('.header-card-dash'),function (i,val) {
                            $(val).children('span').text(Dat.name);
                        });

                        config.data.labels = Dat.act_label;
                        config.data.datasets = [];
                        loopGrapRadar([Dat.max, Dat.min, Dat.last_score]);
                        myRadar.update();

                        $.each(Dat.date_label, function (i, val) {
                            lineData.data.labels.push(moment(val));
                        });

                        lineData.data.datasets=[];
                        $.each(Dat.list, function (i, val) {
                            lineData.data.datasets.push({
                                fillColor: "rgba(255,255,255,0)",
                                strokeColor: "rgba(16,133,135,1)",
                                pointStrokeColor: "#fff",
                                label: i,
                                backgroundColor: arColorChart[z].bg,
                                borderColor: arColorChart[z].border,
                                pointBackgroundColor: arColorChart[z].border,
                                fill: false,
                                data: [],
                                notes: [],
                                act: []
                            });
                            changeProper(val, lineData.data.datasets[z]);

                            z++;
                        });


                        setTimeout(function () {
                            myChart.update();
                            loadMagnify.hide();
                            targetFill.show();
                        }, 1000);


                    })
                    .catch(er => {
                        console.log(er);
                        noticeListTable(er.response);
                    })
            },
            loopGrapRadar = function (dataN) {
                $.each(dataN, function (z, daT) {
                    config.data.datasets.push({
                        label: listLabel[z],
                        backgroundColor: arColorChart[z].bg,
                        borderColor: arColorChart[z].border,
                        pointBackgroundColor: arColorChart[z].border,
                        data: [],
                        notes: [],
                        act: []
                    });

                    changeProper(daT, config.data.datasets[z]);

                });
            },
            changeProper = function (datass, objN) {
                let score_pick = [], date_pick = [], achiv_pick = [], note_pick = [], act_pick = [];
                $.each(datass, function (i, val) {
                    score_pick.push(val.value);
                    date_pick.push(val.date);
                    achiv_pick.push(val.achievement);
                    note_pick.push(val.note);
                    act_pick.push(val.activity_sub);
                });
                objN.data = score_pick;
                objN.notes = note_pick;
                objN.achivs = achiv_pick;
                objN.acts = act_pick;
                objN.dats = date_pick;
            }
        ;

        let lineData = {type: 'line',
            data:{},
            options: {
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                legend: {
                    display: true,
                    position: 'bottom'

                },
                scales: {
                    yAxes: [{
                        ticks: {
                            suggestedMin: 0,
                            suggestedMax: 4
                        }
                    }],
                    xAxes: [{
                        type: 'time',
                        distribution: 'linear',
                        time: {
                            displayFormats: {
                                // 'millisecond': 'MMM DD',
                                // 'second': 'MMM DD',
                                // 'minute': 'MMM DD',
                                'hour': 'MMM DD',
                                'day': 'MMM DD',
                                'week': 'MMM DD',
                                'month': 'MMM DD',
                                'quarter': 'MMM DD',
                                'year': 'MMM DD',
                            }
                        },
                        /* ticks: {
                             callback: function(value) {
                                 return new Date(value).toLocaleDateString('id', {month:'short', year:'numeric'});
                             },
                         },*/
                        // scaleLabel: {
                        //     display: true,
                        //     labelString: 'Date'
                        // }
                    }],
                },
                tooltips: {
                    enabled: false,
                    callbacks: {
                        label: function (tooltipItem, data) {
                            var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                            //This will be the tooltip.body
                            return datasetLabel + ': ' + tooltipItem.yLabel + '<br>Kegiatan: ' +
                                data.datasets[tooltipItem.datasetIndex].acts[tooltipItem.index] + '<br>Kemajuan: ' +
                                data.datasets[tooltipItem.datasetIndex].achivs[tooltipItem.index] + '<br>Catatan: ' +
                                data.datasets[tooltipItem.datasetIndex].notes[tooltipItem.index];
                        }
                    },
                    custom: function (tooltip) {
                        // Tooltip Element
                        var tooltipEl = document.getElementById('chartjs-tooltip');
                        if (!tooltipEl) {
                            tooltipEl = document.createElement('div');
                            tooltipEl.id = 'chartjs-tooltip';
                            tooltipEl.innerHTML = "<table></table>";
                            document.body.appendChild(tooltipEl);
                        }
                        // Hide if no tooltip
                        if (tooltip.opacity === 0) {
                            tooltipEl.style.opacity = 0;
                            return;
                        }
                        // Set caret Position
                        tooltipEl.classList.remove('above', 'below', 'no-transform');
                        if (tooltip.yAlign) {
                            tooltipEl.classList.add(tooltip.yAlign);
                        } else {
                            tooltipEl.classList.add('no-transform');
                        }

                        function getBody(bodyItem) {
                            return bodyItem.lines;
                        }

                        // Set Text
                        if (tooltip.body) {
                            var titleLines = tooltip.title || [];
                            var bodyLines = tooltip.body.map(getBody);
                            var innerHtml = '<thead>';
                            titleLines.forEach(function (title) {
                                innerHtml += '<tr><th>' + title + '</th></tr>';
                            });
                            innerHtml += '</thead><tbody>';
                            bodyLines.forEach(function (body, i) {
                                var colors = tooltip.labelColors[i];
                                var style = 'background:' + colors.backgroundColor;
                                style += '; border-color:' + colors.borderColor;
                                style += '; border-width: 2px';
                                var span = '<span class="chartjs-tooltip-key" style="' + style + '"></span>';
                                innerHtml += '<tr><td>' + span + body + '</td></tr>';
                            });
                            innerHtml += '</tbody>';
                            var tableRoot = tooltipEl.querySelector('table');
                            tableRoot.innerHTML = innerHtml;
                        }
                        var position = this._chart.canvas.getBoundingClientRect();
                        // Display, position, and set styles for font
                        tooltipEl.style.opacity = 1;
                        tooltipEl.style.left = position.left + tooltip.caretX + 'px';
                        tooltipEl.style.top = position.top + tooltip.caretY + 'px';
                        tooltipEl.style.fontFamily = tooltip._fontFamily;
                        tooltipEl.style.fontSize = tooltip.fontSize;
                        tooltipEl.style.fontStyle = tooltip._fontStyle;
                        tooltipEl.style.padding = tooltip.yPadding + 'px ' + tooltip.xPadding + 'px';
                        tooltipEl.style.maxWidth = '30em';
                        tooltipEl.style.minWidth = '15em';
                        tooltipEl.style.zIndex = 2;
                    }
                }

            }};



        $(document).ready(function () {
            $('.content-up').css('padding-bottom','3em');
            let Student = placeRight.find(targetStudent);
            $('.user-list-right').parent().css('padding', 0).css('border-top', '1px dashed #eee');
            if (Student.length > 0) {
                dataQ = {
                    student_key: getUrlParameter('student') ? getUrlParameter('student') : (Student.eq(0).data('key') ? Student.eq(0).data('key') : null),
                };
                getDataAsync();
            } else {
                targetObj.eq(0).hide();
                not_found.show();
            }
        });


        var config = {
            type: 'radar',
            data: {},
            options: {
                legend: {
                    position: 'bottom',
                },
                scale: {
                    ticks: {
                        beginAtZero: true
                    }
                },
                tooltips: {
                    enabled: false,
                    callbacks: {
                        label: function (tooltipItem, data) {
                            var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                            //This will be the tooltip.body
                            return datasetLabel + ': ' + tooltipItem.yLabel + '<br>Kegiatan: ' +
                                data.datasets[tooltipItem.datasetIndex].acts[tooltipItem.index] + '<br>Kemajuan: ' +
                                data.datasets[tooltipItem.datasetIndex].achivs[tooltipItem.index] + '<br>Catatan: ' +
                                data.datasets[tooltipItem.datasetIndex].notes[tooltipItem.index] + '<br>Tanggal: ' +
                                moment(data.datasets[tooltipItem.datasetIndex].dats[tooltipItem.index]).format('DD MMM YY');
                        }
                    },
                    custom: function (tooltip) {
                        // Tooltip Element
                        var tooltipEl = document.getElementById('chartjs-tooltip');
                        if (!tooltipEl) {
                            tooltipEl = document.createElement('div');
                            tooltipEl.id = 'chartjs-tooltip';
                            tooltipEl.innerHTML = "<table></table>";
                            document.body.appendChild(tooltipEl);
                        }
                        // Hide if no tooltip
                        if (tooltip.opacity === 0) {
                            tooltipEl.style.opacity = 0;
                            return;
                        }
                        // Set caret Position
                        tooltipEl.classList.remove('above', 'below', 'no-transform');
                        if (tooltip.yAlign) {
                            tooltipEl.classList.add(tooltip.yAlign);
                        } else {
                            tooltipEl.classList.add('no-transform');
                        }

                        function getBody(bodyItem) {
                            return bodyItem.lines;
                        }

                        // Set Text
                        if (tooltip.body) {
                            var titleLines = tooltip.title || [];
                            var bodyLines = tooltip.body.map(getBody);
                            var innerHtml = '<thead>';
                            titleLines.forEach(function (title) {
                                innerHtml += '<tr><th>' + title + '</th></tr>';
                            });
                            innerHtml += '</thead><tbody>';
                            bodyLines.forEach(function (body, i) {
                                var colors = tooltip.labelColors[i];
                                var style = 'background:' + colors.backgroundColor;
                                style += '; border-color:' + colors.borderColor;
                                style += '; border-width: 2px';
                                var span = '<span class="chartjs-tooltip-key" style="' + style + '"></span>';
                                innerHtml += '<tr><td>' + span + body + '</td></tr>';
                            });
                            innerHtml += '</tbody>';
                            var tableRoot = tooltipEl.querySelector('table');
                            tableRoot.innerHTML = innerHtml;
                        }
                        var position = this._chart.canvas.getBoundingClientRect();
                        // Display, position, and set styles for font
                        tooltipEl.style.opacity = 1;
                        tooltipEl.style.left = position.left + tooltip.caretX + 'px';
                        tooltipEl.style.top = position.top + tooltip.caretY + 400 + 'px';
                        tooltipEl.style.fontFamily = tooltip._fontFamily;
                        tooltipEl.style.fontSize = tooltip.fontSize;
                        tooltipEl.style.fontStyle = tooltip._fontStyle;
                        tooltipEl.style.padding = tooltip.yPadding + 'px ' + tooltip.xPadding + 'px';
                        tooltipEl.style.maxWidth = '30em';
                        tooltipEl.style.minWidth = '15em';
                        tooltipEl.style.zIndex = 2;
                    }
                }
            }
        };

        placeRight.on('click',targetStudent,function () {
            dataQ.student_key=$(this).data('key');
            getDataAsync();
        });

        $('.fa-times').click(function () {
            $(this).parent().fadeOut(300).next().fadeOut(300);
        });

        var myRadar = new Chart(document.getElementById("canvas"), config);
        var myChart = new Chart(ctx, lineData);


    });
}
