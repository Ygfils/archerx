async function buscar_usuario(registro){
    //console.log(registro)

    // receber a matricula
    var matricula = document.querySelector('#matricula')

    var valor_matricula = matricula.value;
    console.log(valor_matricula)

    // Verificar matricula
    if (valor_matricula.length == 6){
        // realizar a requisição
        const dados = await fetch('buscar_usuario.php?matricula=' + valor_matricula);
        // ler os dados
        const resposta = await dados.json();
        console.log(resposta);
        // verificar se retona erro
        if(resposta['erro'] == true){
            //erro
        }else{

            document.getElementById('nome').value = resposta['dados'][0]['Nome'];
            document.getElementById('setor').value = resposta['dados'][0]['departamento'];
            document.getElementById('cartao').value = resposta['dados'][0]['Cartao'];
            document.getElementById('pis').value = resposta['dados'][0]['Pis'];                        
            document.getElementById('cadastrar_funcionario').setAttribute('disabled',true);
            
            if(resposta['dados'][1]['Bloqueado'] == 1){
                document.getElementById('situacao_bloqueio').value = 'BLOQUEADO';
            } else {
                document.getElementById('situacao_bloqueio').value = 'LIBERADO';
            }
            
            
            if(resposta['dados'][0]['Situacao'] == 1){
                document.getElementById('situacao').value = 'DEMITIDO';
                document.getElementById('demissao').value = resposta['dados'][0]['DataDemissao'];
            } else {
                document.getElementById('situacao').value = 'TRABALHANDO';
            }
            if(resposta['dados'][0]['HeadEmprestimo'] != null){// EM CASO DE EMPRESTIMO

                document.getElementById('headset_aual').value = resposta['dados'][0]['HeadEmprestimo'];
                document.getElementById('situacao_head').value = 'EMPRESTADO';

                document.getElementById('baixa_head').setAttribute('disabled',true);                        
                document.getElementById('atualizar_head').setAttribute('disabled',true);                      
                document.getElementById('baixa_emprestimo').removeAttribute('disabled',true);

            }else{
                if(resposta['dados'][0]['HeadAtual'] != null){// QUANDO HÁ UM HEADSET EM USO

                    document.getElementById('headset_aual').value = resposta['dados'][0]['HeadAtual'];
                    document.getElementById('situacao_head').value = 'EM USO';

                    document.getElementById('baixa_head').removeAttribute('disabled',true);                        
                    document.getElementById('atualizar_head').removeAttribute('disabled',true);                        
                    document.getElementById('baixa_emprestimo').setAttribute('disabled',true);

                }else{
                    if(resposta['dados'][0]['HeadAntigo'] != null){// QUNDO FOI DEVOLVIDO

                        document.getElementById('headset_aual').value = resposta['dados'][0]['HeadAntigo'];
                        document.getElementById('situacao_head').value = 'DEVOLVIDO';

                        document.getElementById('baixa_head').setAttribute('disabled',true);                        
                        document.getElementById('atualizar_head').removeAttribute('disabled',true);                        
                        document.getElementById('baixa_emprestimo').setAttribute('disabled',true);

                    }else{
                        document.getElementById('headset_aual').value = "";

                        document.getElementById('baixa_head').setAttribute('disabled',true);                        
                        document.getElementById('atualizar_head').removeAttribute('disabled',true);                        
                        document.getElementById('baixa_emprestimo').setAttribute('disabled',true);

                    }
                }
            }
        }
        await busca_cartao_provisorio();
    }
}
function verifica_selecionado(opcao){
    console.log(opcao)
    if (opcao == 'troca'){
        document.getElementById('chamado').removeAttribute('disabled',true)
    }
    if (opcao == 'integracao'){
        document.getElementById('chamado').setAttribute('disabled',true)
    }
    if (opcao == 'emprestimo'){
        document.getElementById('chamado').setAttribute('disabled',true)
    }
}
async function busca_cartao_provisorio(){
    var matricula = document.querySelector('#matricula')

    var valor_matricula = matricula.value;
    console.log(valor_matricula)
    // realizar a requisição
    const dados_provisorio = await fetch('busca_provisorio.php?matricula=' + valor_matricula);
    // ler os dados
    const resposta_provisorio = await dados_provisorio.json();
    console.log(resposta_provisorio);
    if(resposta_provisorio['erro'] == true){
        //erro
    }else{
        if(resposta_provisorio['dados'].length != 0){
            console.log(resposta_provisorio['dados'][0]['NumeroCartao'])
            document.getElementById('cartao_provisorio').value = resposta_provisorio['dados'][0]['NumeroCartao'];
            document.getElementById('desassociar').removeAttribute('disabled',true)
            document.getElementById('associar').setAttribute('disabled',true)
        }else{
            document.getElementById('associar').removeAttribute('disabled',true)
            document.getElementById('desassociar').setAttribute('disabled',true)
        }
    }
}
async function atualizar_headset(){
    
    // COLETANDO AS VARIÁVEIS
    var matricula = document.querySelector('#matricula');
    var head_novo = document.querySelector('#headset_novo');
    var chamado = document.querySelector('#chamado');
    var motivo = document.querySelector('#opcao');
    var desconto = document.querySelector('#desconto');

    var valor_matricula = matricula.value;
    var valor_head_novo = head_novo.value;
    var valor_chamado = chamado.value;
    var valor_motivo = motivo.value;
    var valor_desconto = desconto.checked;

    var dados_head = [valor_matricula,valor_head_novo ,valor_chamado ,valor_motivo ,valor_desconto];
    console.log(dados_head);

    // BUSCAR QUAL TIPO DE ALTERAÇÃO
    if (valor_motivo == 'integracao'){
        var motivo = 1
    }
    if (valor_motivo == 'troca'){
        var motivo = 2
    }
    if (valor_motivo == 'correcao'){
        var motivo = 3
    }
    if (valor_motivo == 'emprestimo'){
        var motivo = 4
    }

    console.log("motivo: " + motivo)

    // realizar a requisição
    const dados = await fetch('atualiza_heads.php?dados_head='+dados_head);
    // ler os dados
    const resposta = await dados.json();
    console.log(resposta);
}