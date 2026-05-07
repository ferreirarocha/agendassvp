// Configurações Globais
const SENHA_CORRETA = "vicentino2026";
const VERSAO_SISTEMA = "2.1"; // Mude aqui para forçar o reload nos celulares

// Este mural agora é fixo no código para testes/exibição global
const muralGlobal = "📌 AVISO DE TESTE: Reunião extraordinária agendada para o próximo domingo. Favor confirmar presença via WhatsApp.";

const eventos = [
    { data: "04/04", titulo: "Missa de Responsabilidade", desc: "Esclarecido em ata.", passado: true },
    { data: "08/04", titulo: "Reunião Ordinária nº 2285", desc: "Salão São Judas Tadeu.", passado: true },
    { data: "10/04", titulo: "Participação na ECAFO", desc: "Reunião às 20h.", passado: true },
    { data: "12/04", titulo: "Terço da Privilegiada", desc: "Realizado às 18h.", passado: true },
    { data: "13/04", titulo: "Reunião do Conselho Particular", desc: "Realizada às 20h.", passado: true },
    { data: "02/05", titulo: "Missa de Responsabilidade", desc: "18:00h na Comunidade São José (Resenha 04).", passado: false },
    { data: "08/05", titulo: "ECAFO", desc: "Sexta-feira, às 20:00h na Comunidade São José.", passado: false },
    { data: "09/05", titulo: "CJ - Comissão de Jovens", desc: "16:30h na Comunidade São José.", passado: false },
    { data: "10/05", titulo: "Dia das Mães", desc: "Exibição de 2 faixas vicentinas.", passado: false },
    { data: "14/05", titulo: "Terço da Conf. Privilegiada", desc: "17:00h na sede do Conselho Particular.", passado: false },
    { data: "17/05", titulo: "Café de Homenagem às Mães", desc: "07:00h na Comunidade São José.", passado: false },
    { data: "17/05", titulo: "Bazar Vicentino", desc: "09:30h às 17:00h na Comunidade São José.", passado: false },
    { data: "18/05", titulo: "Reunião do Conselho Particular", desc: "20:00h na Comunidade São José.", passado: false },
    { data: "A definir", titulo: "Reuniões ao Ar Livre", desc: "Novos projetos em planejamento.", passado: false },
    { data: "A definir", titulo: "Manhã de Oração", desc: "Planejamento espiritual da conferência.", passado: false }
];
