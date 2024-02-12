const cards = document.querySelectorAll('.cardInside');

const cardInfo = document.getElementById('card-info'); 

cards.forEach(card => {
   card.addEventListener('click', () => {

      const cardId = card.getAttribute('data-card-id');
      switch (cardId) {
        case 'afta':
            cardInfo.innerHTML = '<h1>Afta</h1><p>A afta, ou úlcera aftosa, é uma ferida pequena e dolorosa que se forma na mucosa oral. Existem três tipos principais: aftas menores, aftas maiores e aftas herpetiformes. Elas podem ser causadas por diversos fatores, incluindo trauma, estresse e alimentação. Geralmente, as aftas cicatrizam em algumas semanas, mas em casos graves ou recorrentes, é aconselhável procurar tratamento médico. Existem opções de tratamento para aliviar a dor e acelerar a cicatrização.</p>';
            break;
        case 'maoclusao':
            cardInfo.innerHTML = '<h1>Má oclusao</h1><p>A má oclusão é uma condição ortodôntica em que os dentes superiores e inferiores não se encaixam adequadamente quando a mandíbula está fechada. Isso pode causar problemas estéticos, de mordida e de função. Tratamentos ortodônticos, como o uso de aparelhos, são comuns para corrigir a má oclusão e melhorar a saúde bucal e a estética.</p>';
            break;
        case 'carie':
            cardInfo.innerHTML = '<h1>Cárie</h1><p>Cárie é uma doença dentária causada pela ação de bactérias que corroem o esmalte dos dentes, levando à formação de cavidades. Os sintomas incluem sensibilidade e dor nos dentes. O tratamento envolve a remoção do tecido afetado e a restauração dos dentes. A prevenção inclui boa higiene bucal, visitas regulares ao dentista e redução do consumo de açúcares e carboidratos.</p>';
            break;
        case 'halitose':
            cardInfo.innerHTML = '<h1>Halitose</h1><p>A halitose, ou mau hálito, é uma condição em que ocorre um odor desagradável na boca. Isso pode ser causado por vários fatores, incluindo higiene bucal inadequada, problemas dentários e condições médicas. O tratamento envolve melhorar a higiene bucal e abordar as causas subjacentes.</p>';
            break;
        case 'fluorose':
            cardInfo.innerHTML = '<h1>Fluorose</h1><p>A fluorose é uma condição que afeta a aparência dos dentes devido à exposição excessiva ao flúor durante o desenvolvimento dentário. Isso pode resultar em manchas e descoloração nos dentes. Embora seja principalmente uma preocupação estética, a fluorose pode ser tratada com procedimentos dentários cosméticos, e sua prevenção envolve o controle do consumo de flúor, principalmente em crianças.</p>';
            break;
        case 'peridontite':
            cardInfo.innerHTML = '<h1>Peridontite</h1><p>A periodontite é uma doença inflamatória crônica das gengivas e dos tecidos de suporte dos dentes, que pode levar à perda de dentes. Ela é causada por infecção bacteriana e geralmente resulta da falta de higiene bucal adequada. O tratamento envolve a remoção de placas bacterianas e tártaro, e em casos avançados, podem ser necessários procedimentos cirúrgicos. A prevenção inclui boa higiene bucal e visitas regulares ao dentista.</p>';
            break;
        case 'moniliase':
            cardInfo.innerHTML = '<h1>Moniliase</h1><p>A monilíase, também conhecida como candidíase oral ou sapinho, é uma infecção fúngica que afeta a mucosa da boca e garganta, causada pelo fungo Candida. Ela se manifesta com manchas brancas na boca, desconforto e pode ser tratada com antifúngicos tópicos ou orais. A prevenção envolve boa higiene bucal e controle de fatores de risco.</p>';
            break;
        case 'bruxismo':
            cardInfo.innerHTML = '<h1>Bruxismo</h1><p>O bruxismo é o hábito involuntário de ranger ou apertar os dentes, podendo ocorrer durante o sono (bruxismo noturno) ou quando a pessoa está acordada (bruxismo diurno). Pode ser causado por estresse, ansiedade e problemas de oclusão dentária, resultando em desgaste dental e outros sintomas. O tratamento envolve o uso de dispositivos de proteção e abordagens para reduzir o estresse e a tensão emocional.</p>';
            break;
        case 'gengivite':
            cardInfo.innerHTML = '<h1>Gengivite</h1><p>A gengivite é uma inflamação das gengivas causada pelo acúmulo de placa bacteriana devido à má higiene bucal. Os sintomas incluem gengivas vermelhas, inchadas e com tendência a sangrar. A gengivite é reversível com uma boa higiene oral, limpeza profissional e, em casos graves, uso de medicamentos. Prevenir a gengivite envolve cuidados com a higiene bucal e visitas regulares ao dentista para evitar a progressão para problemas mais graves.</p>';
            break;
        case 'fluorose':
            cardInfo.innerHTML = '<h1>Fluorose</h1><p>A fluorose dentária é uma condição estética que afeta a aparência dos dentes devido à exposição excessiva ao flúor durante o desenvolvimento dentário. Ela pode causar manchas e descoloração nos dentes. O tratamento varia de acordo com a gravidade e pode envolver procedimentos cosméticos. A prevenção inclui o controle da exposição ao flúor, especialmente em crianças, através de uma higiene bucal adequada.</p>';
            break;
            
         default:
            cardInfo.innerHTML = '<h1>Informações não encontradas.</h1>';
      }
   });
});

window.addEventListener('load', function() {
  const aftaCard = document.getElementById('afta-card');
  if (aftaCard) {
     aftaCard.click();
  }
});

cards.forEach(card => {
card.addEventListener('click', () => {
    cards.forEach(otherCard => otherCard.classList.remove('selected'));

    card.classList.add('selected');
});
});
