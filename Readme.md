# Representantes Manager

Plugin WordPress para gerenciamento de representantes e cidades com relacionamento múltiplo.

## 🚀 Funcionalidades

- Cadastro de cidades
- Cadastro de representantes
- Relacionamento many-to-many (representante ↔ cidades)
- Edição e exclusão com validação
- Interface administrativa simples (estilo WordPress)
- Widgets Elementor:
  - Listagem de representantes
  - Sidebar de cidades
  - Busca por nome ou cidade

## 🧱 Estrutura

- `cidades` → lista de cidades
- `representantes` → dados dos vendedores
- `representantes_cidades` → relacionamento

## ⚙️ Instalação

1. Envie o plugin para `/wp-content/plugins/`
2. Ative no WordPress
3. As tabelas serão criadas automaticamente

## 📌 Uso

- Acesse o menu **Representantes**
- Cadastre cidades
- Cadastre representantes e vincule às cidades
- Use os widgets no Elementor

## 🔒 Segurança

- Sanitização de dados
- Nonce em ações críticas
- Proteção contra duplicidade no relacionamento
