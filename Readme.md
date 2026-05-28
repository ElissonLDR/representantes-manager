# Representantes Manager

Plugin WordPress para gerenciamento de representantes e cidades com relacionamento múltiplo.

## Funcionalidades

- Cadastro de cidades
- Cadastro de representantes
- Relacionamento many-to-many (representante ↔ cidades)
- Múltiplos telefones por representante
- Edição e exclusão com validação
- Permissão própria (`manage_representantes`) integrada ao plugin **Members**
- Widgets Elementor: listagem, sidebar de cidades e busca

## Instalação

1. Envie a pasta do plugin para `/wp-content/plugins/representantes-manager/`
2. Ative no WordPress
3. As tabelas são criadas/atualizadas automaticamente

> No servidor Vicato o plugin fica na pasta `representantes-manager`. Ao gerar ZIP para upload, use essa pasta como raiz do arquivo.

## Members (permissões)

1. Ative o plugin **Members**
2. Vá em **Usuários → Funções** e edite a função desejada
3. No grupo **Representantes Manager**, marque **Gerenciar representantes e cidades**

## Uso

- Menu **Representantes** no admin
- Cadastre cidades e representantes
- Use os widgets no Elementor

## Changelog

### 1.0.2
- Capability `manage_representantes` e integração com Members
- Correção de ativação e upgrade automático do banco (tabela de telefones)
- Carregamento admin/Elementor mais seguro
