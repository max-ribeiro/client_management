<script>
import BaseButton from '../UI/Buttons/BaseButton.vue';
import LeftArrowIcon from '../../../icons/left.svg?component'
import ExportIcon from '../../../icons/export.svg?component';

import { Bar, Pie, Doughnut } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement } from 'chart.js'

import notify from '../../Utils/Notify';
import { ExportToPdf } from  'vue-doc-exporter';

import axios from 'axios';


ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement)

export default {
    name: 'Charts',
    components: {
        BaseButton,
        LeftArrowIcon,
        Doughnut,
        Bar,
        Pie,
        ExportToPdf,
        ExportIcon
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
            },
            defaultColors: [
                '#3b82f6', // azul
                '#10b981', // verde
                '#f59e0b', // amarelo
                '#ef4444', // vermelho
                '#8b5cf6', // roxo
                '#ec4899', // rosa
                '#f472b6', // rosa claro
                '#06b6d4', // ciano
                '#facc15', // amarelo claro
                '#14b8a6'  // teal
            ]
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
                            backgroundColor: this.defaultColors
                        }]
                    };

                    this.chartState = {
                        labels: state.map(item => item.state),
                        datasets: [{
                            label: 'Clientes por Estado',
                            data: state.map(item => item.total),
                            backgroundColor: this.defaultColors
                        }]
                    };

                    this.chartAge = {
                        labels: ageRanges.map(item => item.age_range),
                        datasets: [{
                            label: 'Clientes por Faixa Etária',
                            data: ageRanges.map(item => item.total),
                            backgroundColor: this.defaultColors
                        }]
                    };
                }
            }).catch(error => {
                notify.error('Erro ao buscar dados de cidade e estado.');
                console.error(error);
            });
        },
        getFileName() {
            const isoString = new Date().toISOString(); // e.g., "2025-08-20T23:45:00.123Z"
            const numericISO = isoString.replace(/[^0-9]/g, "");
            return `clients_${numericISO}`;
        }
    }
};
</script>

<template>
    <div class="bg-gray-100 min-h-screen p-6" id="charts">
        <div class="max-w-5xl mx-auto">
            <h1 class="text-xl font-semibold text-gray-800 mb-4">Dados sobre clientes</h1>
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex flex-row justify-between">
                    <base-button variant="secondary" @click="navigateBack">
                        <left-arrow-icon></left-arrow-icon> Voltar
                    </base-button>
                    <ExportToPdf :filename="getFileName()">
                        <base-button variant="secondary" title="exportar PDF">
                            <export-icon fill="#505050" class="w-[16px]"></export-icon> PDF
                        </base-button>
                    </ExportToPdf>
                </div>
                <section id="charts-section" class="print-container">
                    <!-- Chart por Cidade -->
                    <h2 class="text-lg font-semibold mb-2 mt-6">Clientes por Cidade</h2>
                    <Bar :data="chartCity" :options="chartOptions" class="mb-8" />
    
                    <!-- Chart por Estado -->
                    <h2 class="text-lg font-semibold mb-2">Clientes por Estado</h2>
                    <Pie :data="chartState" :options="chartOptions" class="mb-8" />
    
                    <!-- Chart por Faixa Etária -->
                    <h2 class="text-lg font-semibold mb-2">Clientes por Faixa Etária</h2>
                    <Doughnut :data="chartAge" :options="chartOptions" />
                </section>
            </div>
        </div>
    </div>
</template>
