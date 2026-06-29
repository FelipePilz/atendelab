<?php

async function carregarPessoas() {
    try {
        const dados = AtendeLabApi.toList(await AtendeLabApi.get('pessoas', 'listar'));
        const tbody = document.getElementById('tabelaPessoas');
        if (!dados.length) {
            tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4">Nenhuma pessoa cadastrada.</td></tr>'; return; }
            tbody.innerHTML = dados.map(p => `<tr>
            <td>${AtendeLabApi.escape(p.nome)}</td>
            <td>${AtendeLabApi.escape(p.documento)}</td>
            <td>${AtendeLabApi.escape(p.email)}</td>
            <td>${AtendeLabApi.escape(p.curso || '')}</td>
            <td>${AtendeLabApi.escape(p.periodo || '')}</td>
            <td><span class="badge ${p.status === 'ativo' ? 'text-bg-sucess' : 'text-bg-secondary'}">${AtendeLabApi.escape(p.status)}</span></td>
            <td class="text-end"><button class="btn btn-sm btn-outline-primary" onclick="editarPessoa(${Number(p.id)})">Editar</button> <button class="btn btn-sm btn-outline-danger" onclick="inativarPessoa(${Number(p.id)})">Inativar</button></td>
            `).join('');
        } catch (error) {
            AtendeLabApi.showAlert('alerta', error.message, 'danger');
        }
    }
}

formPessoa.addEventListener('submit', async event => {
    event.preventDefault();
    const id = document.getElementById("pessoaId").value;
    try {
        await AtendeLabApi.post('pessoas', id ? 'atualizar' : 'criar', new FormData(formPessoa));
        AtendeLabApi.showAlert('alerta', id ? 'Pessoa atualizada com sucesso.' : 'Pessoa cadastrada com sucesso');
        fecharFormulario(); await carregarPessoas();
    } catch (error) {
        AtendeLabApi.showAlert('alerta', error.message, 'danger');}
    }
});