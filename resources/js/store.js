import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        payment_credit: 0,
        paymentList: [],
        status: false
    },
    getters: {
        getPaymentCount: (state, getters) => {
            return state.paymentList.length;
        },
        paymentHistoryCredits: (state, getters) => {
            let credit = 0;
            state.paymentList.forEach(element => {
                if (element.status == '00' || element.status == '08') {
                    credit = credit + parseInt(element.amount);
                }
            })
            credit = credit.toFixed(2);
            return credit;
            // return state.paymentList.;
        }
    },
    mutations: {
        ADD_CREDITS: (state, payments) => {
            state.paymentList.push(payments)
            let credit = 0;
            state.paymentList.forEach(element => {
                if (element.status == '00' || element.status == '08') {
                    credit = credit + parseInt(element.amount);
                }
            })
            state.payment_credit = credit;
        },
        EDIT_CREDIT: (state, credit) => {
            if (credit != null) {
                if (typeof credit == 'object') {
                    if (credit.status == 1) {
                        state.payment_credit = state.payment_credit - parseInt(credit.credits);
                    } else {
                        state.payment_credit = state.payment_credit + parseInt(credit.credits);
                    }
                }
            }
        },
        UPDATED_CREDIT: (state, credit) => {

            if (credit != null) {
                if (typeof credit == 'object') {
                    if (credit.status == 0) {
                        state.payment_credit = state.payment_credit - parseInt(credit.credits);
                    } else {
                        state.payment_credit = state.payment_credit + parseInt(credit.credits);
                    }
                } else {
                    state.payment_credit = state.payment_credit - credit;
                }
            }


        },
        ADD_CREDIT_HISTORY: (state, payments) => {
            state.paymentList = payments
            let credit = 0;
            state.paymentList.forEach(element => {
                if (element.status == '00' || element.status == '08') {
                    credit = credit + parseInt(element.amount);
                }
            })
            state.payment_credit = credit;
        },
        PAYMENT_CREDITS(state, credits) {
            console.log(credits);
        }
    },
    actions: {
        updateCredits({ commit }, credit) {
            commit('UPDATED_CREDIT', credit);
        },
        editCredits({ commit }, credit) {
            commit('EDIT_CREDIT', credit);
        }

    }
})
