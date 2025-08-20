<script>
import BaseButton from '../UI/Buttons/BaseButton.vue';
import LeftArrowIcon from '../../../icons/left.svg?component'
import { Bar, Pie, Doughnut } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement } from 'chart.js'
import notify from '../../Utils/Notify';
import axios from 'axios';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement)

export default {
    name: 'Charts',
    components: {
        BaseButton,
        LeftArrowIcon,
        Doughnut,
        Bar,
        Pie
    },
    data() {
        return {
            chartCity: { labels: [], datasets: [] },
            chartState: { labels: [], datasets: [] },
            chartAge: { labels: [], datasets: [] }, // <-- novo gráfico
            chartOptions: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: false }
                }
            }
        }
    },
    mounted() {
        this.getChartData();
    },
    methods: {
        navigateBack() {
            this.$router.push('/clients');
        },
        getChartData() {
            const token = localStorage.getItem('token');

            axios.get('/api/reports', {
                headers: { Authorization: `Bearer ${token}`, Accept: 'application/json' }
            }).then(response => {
                if (response.status === 200) {
                    const { city, state, ageRanges } = response.data;

                    this.chartCity = {
                        labels: city.map(item => item.city),
                        datasets: [{
                            label: 'Clientes por Cidade',
                            data: city.map(item => item.total),
                            backgroundColor: '#3b82f6'
                        }]
                    };

                    this.chartState = {
                        labels: state.map(item => item.state),
                        datasets: [{
                            label: 'Clientes por Estado',
                            data: state.map(item => item.total),
                            backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444']
                        }]
                    };

                    this.chartAge = {
                        labels: ageRanges.map(item => item.age_range),
                        datasets: [{
                            label: 'Clientes por Faixa Etária',
                            data: ageRanges.map(item => item.total),
                            backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444']
                        }]
                    };
                }
            }).catch(error => {
                notify.error('Erro ao buscar dados de cidade e estado.');
                console.error(error);
            });
        },
    }
};
</script>

<template>
    <div class="bg-gray-100 min-h-screen p-6" id="charts">
        <div class="max-w-5xl mx-auto">
            <h1 class="text-xl font-semibold text-gray-800 mb-4">Dados sobre clientes</h1>
            <div class="bg-white rounded-xl shadow p-6">
                <base-button variant="secondary" @click="navigateBack">
                    <left-arrow-icon></left-arrow-icon> Voltar
                </base-button>

                <!-- Chart por Cidade -->
                <h2 class="text-lg font-semibold mb-2 mt-6">Clientes por Cidade</h2>
                <Bar :data="chartCity" :options="chartOptions" class="mb-8" />

                <!-- Chart por Estado -->
                <h2 class="text-lg font-semibold mb-2">Clientes por Estado</h2>
                <Pie :data="chartState" :options="chartOptions" class="mb-8" />

                <!-- Chart por Faixa Etária -->
                <h2 class="text-lg font-semibold mb-2">Clientes por Faixa Etária</h2>
                <Doughnut :data="chartAge" :options="chartOptions" />
            </div>
        </div>
    </div>
</template>
