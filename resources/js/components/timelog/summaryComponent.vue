<template>
    <div class="timelog">
        <div class="card shadow mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="m-0"><a href="/timelog" class="btn btn-primary btn-sm mr-2"><i class="fas fa-long-arrow-alt-left"></i>&nbsp;<small>Back</small></a> Timelog Summary</h5>
                <span>{{ new Date() | moment("dddd, MMMM DD YYYY") }}</span>
            </div>
            <div class="card-body">
                <v-client-table :data="summary_list" :columns="columns" :options="options" ref="summaryTable">
                    <div class="d-flex" slot="afterFilter">
                        <div class="form-inline form-row">
                            <div class="col">
                                <input type="text" class="form-control" placeholder="From Date" />
                            </div>
                            <div class="col">—</div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="To Date" />
                            </div>
                        </div>
                    </div>
                    <!-- <div slot="hours_worked" slot-scope="{h, row}">
                        {{ row.hours_worked }}
                    </div> -->
                    <!-- <div class="btn-group" slot="actions" slot-scope="{row}">
                        <a href="#directEdit" class="btn btn-primary btn-sm" @click="edit(row)"> <i class="fas fa-edit"> </i></a>
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm text-white" @click="remove(row.id)"> <i class="fas fa-trash"> </i></a>
                    </div>
                    <span slot="active" slot-scope="{row}" :class="'badge '+[row.active? 'badge-success' : 'badge-danger']">{{ row.active? 'Active' : 'Inactive' }}</span> -->
                    

                    <tfoot slot="afterBody">
                        <tr>
                            <td colspan="4"></td>
                            <td class="font-weight-bold">Total:</td>
                            <!-- <td</td> -->
                            <td>163 min(s)</td>
                            <td>17 min(s)</td>
                        </tr>
                    </tfoot>
                </v-client-table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return{
            moment: moment,
            summary_list: [],

            // Vue-Tables-2 Syntax
            columns: ['date', 'day', 'time_in', 'time_out', 'hours_worked', 'total_mins_break', 'total_mins_tardy', 'overall_hours_worked'],
            options: {
                initialPage:1,
                perPage:31,
                highlightMatches:true,
                sortIcon: { base:'fas', up:'fa-sort-amount-up', down:'fa-sort-amount-down', is:'fa-sort' },
                filterable: false,
                headings: {
                    date: 'Date',
                    day: 'Day',
                    time_in: 'Time In',
                    time_out: 'Time Out',
                    hours_worked: 'Hours Worked',
                    total_mins_break: 'Total Breaks',
                    total_mins_tardy: 'Total Tardy',
                },
                hiddenColumns: ['overall_hours_worked'],
                // sortable: ['date', 'day', 'time_in', 'time_out', 'hours_worked', 'total_mins_break', 'total_mins_tardy'],
                rowClassCallback(row) {
                    return row.id = row.id;
                },
                columnClasses: {id: 'class-is'},
                texts: {
                    filter: "Search:",
                    filterPlaceholder: "Search keywords",
                },
                templates:{
                    date: function(h, row) {
                        return row.time_in ? moment(row.time_in).format('MMM DD, YYYY') : '--:--:--';
                    },
                    day: function(h, row) {
                        return row.time_in ? moment(row.time_in).format('ddd') : '--:--:--';
                    },
                    time_in: function(h, row) {
                        return row.time_in ? moment(row.time_in).format('hh:mm A') : '--:--:--';
                    },
                    time_out: function(h, row) {
                        return row.time_out ? moment(row.time_out).format('hh:mm A') : '--:--:--';
                    },
                    hours_worked: function(h, row) {
                        if (row.time_out != null) {
                            let timein = moment(row.time_in);
                            let timeout = moment(row.time_out);
                            return moment.duration(timeout.diff(timein)).hours() + ' hrs ' + moment.duration(timeout.diff(timein)).minutes() + ' mins';
                        } else {
                            return '--';
                        }
                    },
                    total_mins_break: function(h, row) {
                        return row.total_mins_break ? row.total_mins_break + ' min(s)' : '--';
                    },
                    total_mins_tardy: function(h, row) {
                        return row.total_mins_tardy ? row.total_mins_tardy + ' min(s)' : '--';
                    },
                    overall_hours_worked: function(h, row) {
                        return 'daasdasd';
                    },
                }
            },
        }
    },
    filters: {
        moment: function (date, format) {
            return moment(date).subtract(1, 'hour').format(format);
        }
    },
    created() {
        this.fetchList();
    },
    methods: {
        fetchList() {
            axios({
                method: 'get',
                url: '/timelog/summary/list/',
            }).then(response => {
                this.summary_list = response.data;
            }).catch(error => {});
        },
    },
}
</script>

<style lang="scss" scoped>

</style>
