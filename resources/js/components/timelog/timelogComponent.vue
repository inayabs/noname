<template>
  <div class="timelog">
    <div class="card shadow mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="m-0">Timelog <a href="/timelog/summary/user" class="btn btn-secondary btn-sm ml-2"><small>Summary</small></a></h5>
            <span>{{ new Date() | moment("dddd, MMMM DD YYYY") }}</span>
        </div>
        <div class="card-body">
            <div class="row timelog-stats">
                <div class="card-col col-lg-3 mb-4">
                    <div class="card border-primary rounded-0">
                        <div class="card-header rounded-0 py-1 px-2 bg-primary text-white"><small class="font-weight-bold">Today's work hours</small></div>
                        <div class="card-body">
                            <h3 class="text-center font-weight-light">2 hr 30 mins</h3>
                        </div>
                    </div>
                </div>
                <div class="card-col col-lg-3 mb-4">
                    <div class="card border-info rounded-0">
                        <div class="card-header rounded-0 py-1 px-2 bg-info text-white"><small class="font-weight-bold">Weekly work hours</small></div>
                        <div class="card-body">
                            <h3 class="text-center font-weight-light">30 hr 30 mins</h3>
                        </div>
                    </div>
                </div>
                <div class="card-col col-lg-3 mb-4">
                    <div class="card border-warning rounded-0">
                        <div class="card-header rounded-0 py-1 px-2 bg-warning text-white"><small class="font-weight-bold">Lates</small></div>
                        <div class="card-body">
                            <h3 class="text-center font-weight-light">20 mins</h3>
                        </div>
                    </div>
                </div>
                <div class="card-col col-lg-3 mb-4">
                    <div class="card border-danger rounded-0">
                        <div class="card-header rounded-0 py-1 px-2 bg-danger text-white"><small class="font-weight-bold">Absents</small></div>
                        <div class="card-body">
                            <h3 class="text-center font-weight-light">3 days</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="d-flex flex-column col-lg-6" :class="[this.timelog_details && this.timelog_details.time_in && this.timelog_details.time_out ? 'btn-disabled' : '']">
                    <div class="form-inline">
                        <div class="input-group w-50">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-bold rounded-0" id="timein-addon rounded-0">Time In:</span>
                            </div>
                            <input type="text" class="form-control rounded-0 border-right-0" value="" v-model="fields.time_in" aria-describedby="timein-addon" :placeholder='[timelog_details != null && timelog_details.time_in ? $options.filters.moment(timelog_list.time_in, "h:mm:ss A") : "--:--:--"]' disabled>
                        </div>
                        <div class="input-group w-50">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-bold rounded-0" id="timeout-addon">Time Out:</span>
                            </div>
                            <input type="text" class="form-control rounded-0" value="" v-model="fields.time_out" aria-describedby="timeout-addon" :placeholder='[timelog_details != null && timelog_details.time_out ? $options.filters.moment(timelog_list.time_out, "h:mm:ss A") : "--:--:--"]' disabled>
                        </div>
                    </div>
                    <div class="">
                        <a href="javascript:void(0)" @click="timelogProcess([])" class="btn rounded-0 w-100" :class="[
                        time_in_btn? 'btn-primary': 'btn-danger',
                        timelog_details && timelog_details.time_in && 
                        break_details && break_details.break_end === null ||
                        timelog_list && timelog_list.total_mins_break === 0 ? 'btn-disabled' : ''
                        ]"><i class="far " :class="[time_in_btn? 'fa-calendar-check': 'fa-calendar-times']"></i> {{ (time_in_btn? 'Time In': 'Time Out') }}</a>
                    </div>
                </div>
                <div class="d-flex flex-column col-lg-6" :class="[timelog_details ? '' : 'btn-disabled', this.timelog_details && this.timelog_details.time_in && this.timelog_details.time_out ? 'btn-disabled' : '']">
                    <div class="form-inline">
                        <div class="input-group position-relative w-100" :class="[start_break_btn ? '': 'on-break']">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-bold rounded-0" id="breaks-addon">Notes:</span>
                            </div>
                            <input type="text" class="form-control rounded-0" value="" v-model="fields.notes" aria-describedby="breaks-addon" placeholder="Add break note.">
                        </div>
                    </div>
                    <div class="btn-group">
                        <a href="javascript:void(0)" @click="startBreakProcess()" class="btn btn-primary rounded-0" :class="[start_break_btn ? '': 'btn-disabled']">Start Break</a>
                        <a href="javascript:void(0)" @click="endBreakProcess()" class="btn btn-primary rounded-0" :class="[start_break_btn ? 'btn-disabled' : '']">End Break</a>
                    </div>
                </div>
            </div>

            <table class="table w-100 mt-4">
                <thead>
                    <tr>
                        <th>Break Started</th>
                        <th>Break Ended</th>
                        <th>Notes</th>
                        <th>Total Break</th>
                    </tr>
                </thead>
                <tbody v-if="timelog_list.breaks != null">
                    <tr v-for="breaks in timelog_list.breaks">
                        <td>{{ breaks.break_start ? $options.filters.moment(breaks.break_start, 'h:mm:ss A') : '--:--:--' }}</td>
                        <td>{{ breaks.break_end ? $options.filters.moment(breaks.break_end, 'h:mm:ss A') : '--:--:--' }}</td>
                        <td>{{ breaks.notes }}</td>
                        <td>{{ breaks.total_breaks ? breaks.total_breaks + ' mins' : '-'}} </td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="4" class="font-weight-bold">No breaks yet!</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2"></td>
                        <td class="font-weight-bold">Total consumed breaks:</td>
                        <td>{{ timelog_details && timelog_list.total_mins_break ? timelog_list.total_mins_break + ' mins': '-'}}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
  </div>
</template>

<script>
export default {
    data() {
        return{
            moment: moment,
            moment_time: '',
            fields: {},
            // Timelog
            timelog_list: [],
            time_in_btn: true,
            time_out_btn: false,
            timelog_details: timelogDetails,
            // Break
            start_break_btn: true,
            end_break_btn: false,
            break_details: breakDetails,
        }
    },
    filters: {
        moment: function (date, format) {
            return moment(date).subtract(1, 'hour').format(format);
        }
    },
    mounted() {
        if(this.timelog_details != null && this.timelog_details.time_in != null) {
            this.time_in_btn = false;
            if(this.timelog_list.total_mins_break > 0) {
                this.time_out_btn = true;
            } else {
                this.time_out_btn = false;
            }
        }
        if(this.break_details != null && this.break_details.break_start != null) {
            this.start_break_btn = false;
            if (this.break_details.break_end != null) {
                this.start_break_btn = true;
            }
        }
    },
    created() {
        this.fetchList();
    },
    methods: {
        fetchList() {
            if (this.timelog_details != null) {
                axios({
                    method: 'get',
                    url: '/timelog/today/list/',
                }).then(response => {
                    this.timelog_list = response.data;
                }).catch(error => {});
            }
        },
        // Timelog Process
        timelogProcess(method) {
            if (this.time_in_btn === true) {
                this.time_in_btn = this.time_out_btn = false;
                this.fields.time_in = this.$moment().format('h:mm:ss a');
                axios({
                    method: 'post',
                    url: '/timelog/time-in/store',
                    data: {
                        time_in: this.$moment().format('YYYY-MM-DD HH:mm:ss'),
                    },
                }).then(response => {
                    Toast.fire({
                        // position: 'top-end',
                        type: 'success',
                        title: 'You\'re logged-in',
                    })
                    location.reload();
                }).catch(error => {
                });
            } else {
                axios({
                    method: 'put',
                    url: '/timelog/time-out/update/'+ this.timelog_details.id,
                    data: {
                        time_out: this.$moment().format('YYYY-MM-DD HH:mm:ss'),
                    },
                }).then(response => {
                    Toast.fire({
                        // position: 'top-end',
                        type: 'success',
                        title: 'You\'re logged-out',
                    })
                    location.reload();
                }).catch(error => {
                });
            }
        },
        // Break Process
        startBreakProcess() {
            this.start_break_btn = false;
            this.time_out_btn = false;
            axios({
                method: 'post',
                url: '/timelog/start-break/store',
                data: {
                    timelog_id: this.timelog_details.id,
                    break_start: this.$moment().format('YYYY-MM-DD HH:mm:ss'),
                    notes: this.fields.notes
                },
            }).then(response => {
                this.time_out_btn = false;
                Toast.fire({
                    // position: 'top-end',
                    type: 'success',
                    title: 'You\'re now on break',
                })
                this.fetchList();
            }).catch(error => {
            });
        },
        endBreakProcess() {
            this.start_break_btn = true;
            axios({
                method: 'put',
                url: '/timelog/end-break/update/'+ this.timelog_details.id,
                data: {
                    break_end: this.$moment().format('YYYY-MM-DD HH:mm:ss'),
                },
            }).then(response => {
                Toast.fire({
                    // position: 'top-end',
                    type: 'success',
                    title: 'You\'ve ended your break',
                })
                this.fetchList();
                if(this.timelog_details != null && this.timelog_list.total_mins_break != null) {
                    this.time_out_btn = true;
                }
            }).catch(error => {
            });
        },
    },
}
</script>

<style lang="scss" scoped>
$black: #000;
$green: #43A047;
$light-green: #8BC34A;
.timelog{

    .timelog-stats{
        .card-col{
            min-height: 100px;
        }
        .card{
            height: 100%;
        }
    }

    .on-break{
        animation: blink 1500ms infinite;
        &::before{
            content: "";
            background-color: rgba($light-green, 0.5);
            height: 100%;
            width: 100%;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 9;
        }
        &::after{
            content: "You're on break";
            color: $green;
            font-weight: bold;
            text-align: center;
            width: 100%;
            padding: 0 10px;
            position: absolute;
            top: 50%;
            left: 50%;
            right: 50%;
            transform: translate(-50%, -50%);
            z-index: 99;
        }
        .input-group-prepend,
        .form-control{
            opacity: 0;
        }
    }
    .btn-disabled{
        opacity: 0.8;
        user-select: none;
        pointer-events: none
    }
}
@keyframes blink {
    0%{opacity: 0.4;}
    25%{opacity: 0.7;}
    50%{opacity: 1;}
    75%{opacity: 0.7;}
    100%{opacity: 0.4;}
}
</style>
