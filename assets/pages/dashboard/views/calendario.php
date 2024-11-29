<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendário com Dia Marcado</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        #calWrapper {
            width: max-content;
            border: 1px solid #ccc;
            padding: 5px;
            border-radius: 10px;
        }
        .dayCell {
            height: 38px;
            width: 44px;
            text-align: center;
            vertical-align: middle;
            border: 1px solid #94c3ef;
            background-color: #daedff;
        }
        .dayHeader {
            height: 21px;
            padding: 3px;
            background-color: #43A0F6;
            color: white;
            font-size: 11pt;
            vertical-align: middle;
        }
        .today {
            border: 2px solid #0681F3;
        }
        .marked {
            background-color: #43a0f6;
            color: white;
            border: 3px solid #43a0f6;
        }
    </style>
</head>
<body>

<div id="calWrapper"></div>



<script>
    function createCalendar(date) {
        const year = date.getFullYear();
        const month = date.getMonth();
        const markedDay = date.getDate(); // O dia da consulta será o dia marcado
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0).getDate();
        const dayOne = firstDay.getDay();

        const days = ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"];
        const calWrapper = document.getElementById("calWrapper");
        calWrapper.innerHTML = ""; // Limpa o conteúdo anterior

        // Cria o cabeçalho dos dias
        const headerRow = document.createElement("tr");
        days.forEach(day => {
            const th = document.createElement("th");
            th.className = "dayHeader";
            th.innerText = day;
            headerRow.appendChild(th);
        });
        calWrapper.appendChild(headerRow);

        let iDay = 0;
        // Preenche as células do calendário
        while (iDay < lastDay) {
            const row = document.createElement("tr");
            for (let i = 0; i < 7; i++) {
                const cell = document.createElement("td");
                if (iDay === 0 && i < dayOne) {
                    cell.innerText = ""; // Células vazias para os dias que não pertencem ao mês
                } else if (iDay < lastDay) {
                    cell.innerText = ++iDay;
                    if (iDay === markedDay && month === date.getMonth() && year === date.getFullYear()) {
                        cell.className = "dayCell marked"; // Marca o dia da consulta
                    } else if (iDay === new Date().getDate() && month === new Date().getMonth() && year === new Date().getFullYear()) {
                        cell.className = "dayCell today"; // Marca o dia atual
                    } else {
                        cell.className = "dayCell";
                    }
                } else {
                    cell.innerText = ""; // Células vazias para dias que excedem o mês
                }
                row.appendChild(cell);
            }
            calWrapper.appendChild(row);
        }
    }

    // Exemplo: Criar um calendário para Novembro de 2024 com o dia 15 marcado
</script>

</body>
</html>
