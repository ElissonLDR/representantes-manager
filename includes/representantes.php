<?php
if (!defined('ABSPATH')) exit;

require_once RM_PATH . 'includes/db.php';
<<<<<<< HEAD
=======
// Elementor (mantido)
>>>>>>> d5ae31fde395fecd55b176c5367858ed25209432
require_once RM_PATH . 'elementor/widgets.php';

function rm_render_representantes_page() {

    if (!current_user_can('manage_options')) return;

    global $wpdb;

    $table = rm_get_table('representantes');
    $rel_table = rm_get_table('rel');
    $cidades_table = rm_get_table('cidades');
<<<<<<< HEAD
    $telefones_table = rm_get_table('telefones');
=======
>>>>>>> d5ae31fde395fecd55b176c5367858ed25209432

    $edit = null;
    $selected_cidades = [];

<<<<<<< HEAD
    // BUSCA
    $search = rm_sanitize_text($_GET['s'] ?? '');

    // RESET
    if (isset($_GET['novo'])) {
        echo '<script>window.location.href="' . admin_url('admin.php?page=rm-representantes') . '";</script>';
        exit;
    }

    // IMPORTAÇÃO TXT
    if (isset($_POST['importar_txt']) && check_admin_referer('rm_rep_nonce')) {

        $linhas = explode("\n", $_POST['bulk_representantes']);

        foreach ($linhas as $linha) {

            if (empty(trim($linha))) continue;
            if (strpos($linha, '|') === false) continue;

            $partes = array_map('trim', explode('|', $linha));

            $nome = $partes[0] ?? '';
            $telefones_raw = $partes[1] ?? '';
            $cidades_raw = $partes[2] ?? '';

            $nome = trim($nome);
            $telefones_array = array_map('trim', explode(',', $telefones_raw));
            $cidades_array = array_map('trim', explode(',', $cidades_raw));

            $wpdb->insert($table, [
                'nome' => $nome,
                'email' => ''
            ]);

            $rep_id = $wpdb->insert_id;

            foreach ($telefones_array as $tel) {
                if (!$tel) continue;

                $wpdb->insert($telefones_table, [
                    'representante_id' => $rep_id,
                    'telefone' => $tel
                ]);
            }

            foreach ($cidades_array as $cidade_str) {

                if (!$cidade_str) continue;
            
                // separa nome + estado
                $partes_cidade = explode('-', $cidade_str);
            
                $nome_cidade = trim($partes_cidade[0] ?? '');
                $estado = trim($partes_cidade[1] ?? 'RS');
            
                if (!$nome_cidade) continue;
            
                // verifica se já existe
                $cidade_id = $wpdb->get_var($wpdb->prepare(
                    "SELECT id FROM $cidades_table WHERE nome = %s",
                    $nome_cidade
                ));
            
                // se não existir → cria
                if (!$cidade_id) {
                    $wpdb->insert($cidades_table, [
                        'nome' => $nome_cidade,
                        'estado' => $estado
                    ]);
            
                    $cidade_id = $wpdb->insert_id;
                }
            
                // cria relação
                $wpdb->insert($rel_table, [
                    'representante_id' => $rep_id,
                    'cidade_id' => $cidade_id
                ]);
            }
        }

        echo '<script>location.href="'.admin_url('admin.php?page=rm-representantes').'";</script>';
        exit;
=======
    // RESET (NOVO)
    if (isset($_GET['novo'])) {
        $edit = null;
        $selected_cidades = [];
>>>>>>> d5ae31fde395fecd55b176c5367858ed25209432
    }

    // CREATE / UPDATE
    if (isset($_POST['rm_save_rep']) && check_admin_referer('rm_rep_nonce')) {

        $id = intval($_POST['id'] ?? 0);
        $nome = rm_sanitize_text($_POST['nome'] ?? '');
<<<<<<< HEAD

        $telefones = $_POST['telefones'] ?? [];
        $telefones = array_map('rm_sanitize_text', $telefones);
        $telefones = array_filter($telefones);
        $telefone = implode(', ', $telefones);

=======
        $telefone = rm_sanitize_text($_POST['telefone'] ?? '');
>>>>>>> d5ae31fde395fecd55b176c5367858ed25209432
        $email = rm_sanitize_email($_POST['email'] ?? '');
        $cidades = $_POST['cidades'] ?? [];

        if ($nome) {

            if ($id > 0) {
<<<<<<< HEAD

                $wpdb->update($table, [
                    'nome' => $nome,
                    'email' => $email
                ], ['id' => $id]);

                $wpdb->delete($rel_table, ['representante_id' => $id]);
                $rep_id = $id;

            } else {

                $wpdb->insert($table, [
                    'nome' => $nome,
=======
                $wpdb->update($table, [
                    'nome' => $nome,
                    'telefone' => $telefone,
                    'email' => $email
                ], ['id' => $id]);

                // limpa relações antigas
                $wpdb->delete($rel_table, ['representante_id' => $id]);

                $rep_id = $id;

            } else {
                $wpdb->insert($table, [
                    'nome' => $nome,
                    'telefone' => $telefone,
>>>>>>> d5ae31fde395fecd55b176c5367858ed25209432
                    'email' => $email
                ]);

                $rep_id = $wpdb->insert_id;
            }

<<<<<<< HEAD
            // TELEFONES (sempre atualiza)
            $wpdb->delete($telefones_table, [
                'representante_id' => $rep_id
            ]);

            foreach ($telefones as $tel) {
                if (!$tel) continue;

                $wpdb->insert($telefones_table, [
                    'representante_id' => $rep_id,
                    'telefone' => $tel
                ]);
            }

            // CIDADES
            $cidades = array_unique(array_map('intval', $cidades));

            foreach ($cidades as $cidade_id) {

                $exists = $wpdb->get_var($wpdb->prepare(
                    "SELECT id FROM $rel_table WHERE representante_id = %d AND cidade_id = %d",
                    $rep_id,
                    $cidade_id
                ));

                if (!$exists) {
                    $wpdb->insert($rel_table, [
                        'representante_id' => $rep_id,
                        'cidade_id' => $cidade_id
                    ]);
                }
            }
        }

        echo '<script>window.location.href="' . admin_url('admin.php?page=rm-representantes') . '";</script>';
        exit;
=======
            // 🔥 evita duplicidade (já pensando no UNIQUE do DB)
            $cidades = array_unique(array_map('intval', $cidades));

            if (!empty($cidades)) {
                foreach ($cidades as $cidade_id) {

                    // evita duplicado manual também
                    $exists = $wpdb->get_var($wpdb->prepare(
                        "SELECT id FROM $rel_table WHERE representante_id = %d AND cidade_id = %d",
                        $rep_id,
                        $cidade_id
                    ));

                    if (!$exists) {
                        $wpdb->insert($rel_table, [
                            'representante_id' => $rep_id,
                            'cidade_id' => $cidade_id
                        ]);
                    }
                }
            }
        }
>>>>>>> d5ae31fde395fecd55b176c5367858ed25209432
    }

    // DELETE
    if (isset($_GET['delete']) && isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'rm_delete_rep')) {

        $id = intval($_GET['delete']);

        $wpdb->delete($table, ['id' => $id]);
        $wpdb->delete($rel_table, ['representante_id' => $id]);
<<<<<<< HEAD
        $wpdb->delete($telefones_table, ['representante_id' => $id]);

        echo '<script>window.location.href="' . admin_url('admin.php?page=rm-representantes') . '";</script>';
        exit;
    }

    // EDIT
    if (isset($_GET['edit'])) {
=======
    }

    // EDIT MODE
    if (isset($_GET['edit']) && !isset($_GET['novo'])) {
>>>>>>> d5ae31fde395fecd55b176c5367858ed25209432

        $edit_id = intval($_GET['edit']);

        $edit = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM $table WHERE id = %d", $edit_id)
        );

        $selected_cidades = $wpdb->get_col(
            $wpdb->prepare(
                "SELECT cidade_id FROM $rel_table WHERE representante_id = %d",
                $edit_id
            )
        );
    }

<<<<<<< HEAD
    // PAGINAÇÃO
    $per_page = intval($_GET['per_page'] ?? 25);
    if (!in_array($per_page, [25,50,100,500])) $per_page = 25;

    $page = max(1, intval($_GET['paged'] ?? 1));
    $offset = ($page - 1) * $per_page;

    // ORDENAÇÃO
    $order_by = $_GET['orderby'] ?? 'id';
    $order = $_GET['order'] ?? 'DESC';
    
    $allowed = ['nome', 'email', 'id'];
    if (!in_array($order_by, $allowed)) $order_by = 'id';
    
    $order = strtoupper($order) === 'ASC' ? 'ASC' : 'DESC';

    // QUERY
    if ($search) {
        $total = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM $table WHERE nome LIKE %s",
            '%' . $wpdb->esc_like($search) . '%'
        ));

        $representantes = $wpdb->get_results($wpdb->prepare("
            SELECT r.*, 
            COUNT(DISTINCT c.id) as total_cidades,
            GROUP_CONCAT(DISTINCT t.telefone SEPARATOR ', ') as telefones
            FROM $table r
            LEFT JOIN $telefones_table t ON t.representante_id = r.id
            LEFT JOIN $rel_table rc ON rc.representante_id = r.id
            LEFT JOIN $cidades_table c ON c.id = rc.cidade_id
            WHERE r.nome LIKE %s
            GROUP BY r.id
            ORDER BY r.$order_by $order
            LIMIT %d OFFSET %d
        ", '%' . $wpdb->esc_like($search) . '%', $per_page, $offset));

    } else {

        $total = $wpdb->get_var("SELECT COUNT(*) FROM $table");

        $representantes = $wpdb->get_results($wpdb->prepare("
            SELECT r.*, 
            COUNT(DISTINCT c.id) as total_cidades,
            GROUP_CONCAT(DISTINCT t.telefone SEPARATOR ', ') as telefones
            FROM $table r
            LEFT JOIN $telefones_table t ON t.representante_id = r.id
            LEFT JOIN $rel_table rc ON rc.representante_id = r.id
            LEFT JOIN $cidades_table c ON c.id = rc.cidade_id
            GROUP BY r.id
            ORDER BY r.$order_by $order
            LIMIT %d OFFSET %d
        ", $per_page, $offset));
    }

    $total_pages = ceil($total / $per_page);
    $cidades = $wpdb->get_results("SELECT * FROM $cidades_table ORDER BY nome ASC");

    // UI (INALTERADA, só checkbox adaptado)
    echo '<div class="wrap"><h1 style="font-size:42px;">Representantes</h1>';
    echo '<div style="display:flex;gap:20px;">';

    // LEFT
    echo '<div style="width:320px;display:flex;flex-direction:column;gap:15px;">';
    echo '<a href="?page=rm-representantes&novo=1" class="button">Novo</a>';

    echo '<div style="background:#fff;border:1px solid #ddd;padding:15px;">';
    echo '<h3>'.($edit ? 'Editando' : 'Adicionar').'</h3>';

    echo '<form method="POST">';
    wp_nonce_field('rm_rep_nonce');

    echo '<input type="hidden" name="id" value="'.esc_attr($edit->id ?? '').'">';
    echo '<input type="text" name="nome" placeholder="Nome" value="'.esc_attr($edit->nome ?? '').'" required style="width:100%;margin-bottom:10px;">';

    echo '<div id="telefones-wrapper">';

    $telefones_edit = [];
    
    if (!empty($edit->id)) {
        $telefones_edit = $wpdb->get_col($wpdb->prepare(
            "SELECT telefone FROM $telefones_table WHERE representante_id = %d",
            $edit->id
        ));
    }
    
    if (empty($telefones_edit)) $telefones_edit = [''];
    
    foreach ($telefones_edit as $tel) {
        echo '<input type="text" name="telefones[]" value="'.esc_attr(trim($tel)).'" style="width:100%;margin-bottom:5px;">';
    }
    
    echo '</div>';

    echo '<button type="button" id="add-telefone" class="button" style="margin-bottom:10px;">+ Telefone</button>';

    echo '<input type="email" name="email" placeholder="Email" value="'.esc_attr($edit->email ?? '').'" style="width:100%;margin-bottom:10px;">';

    echo '<div style="border:1px solid #ccd0d4;background:#fff;padding:8px;max-height:150px;overflow:auto;margin-bottom:10px;">';
    foreach ($cidades as $cidade) {
        $checked = in_array($cidade->id, $selected_cidades) ? 'checked' : '';
        echo '<label style="display:flex;align-items:center;gap:6px;margin-bottom:4px;">';
        echo '<input type="checkbox" name="cidades[]" value="'.$cidade->id.'" '.$checked.'>';
        echo '<span>'.$cidade->nome.'</span>';
        echo '</label>';
    }
    echo '</div>';

    echo '<button type="submit" name="rm_save_rep" class="button button-primary" style="width:100%;">Salvar</button>';
    echo '</form></div>';

    // IMPORT
    echo '<div style="background:#fff;border:1px solid #ddd;padding:15px;margin-top:15px;">';
    echo '<h3>Adicionar vários</h3>';
    echo '<form method="POST">';
    wp_nonce_field('rm_rep_nonce');
    echo '<textarea name="bulk_representantes" placeholder="Exemplo:
    Nome | (DDD) 99999-9999 | Cidade-RS, Cidade-SC"" style="width:100%;height:120px;margin-bottom:10px;"></textarea>';
    echo '<button name="importar_txt" class="button button-primary" style="width:100%;">Importar</button>';
    echo '</form></div>';

    echo '</div>';

    // RIGHT
    echo '<div style="flex:1;">';

    echo '<div style="display:flex;justify-content:space-between;margin-bottom:15px;">';

    echo '<form id="rm-filtro-form" method="GET" style="display:flex;gap:50px;align-items:center;justify-content:space-between;width:100%;">';
    echo '<input type="hidden" name="page" value="rm-representantes">';
    
    echo '<div>';
    echo '<input id="rm-search" type="text" style="width:300px;margin-right:20px;" name="s" value="'.esc_attr($search).'" placeholder="Buscar...">';
    echo '<strong>Total: '.intval($total).'</strong>';
    echo '</div>';
    
    echo '<select id="rm-per-page" name="per_page">';
    foreach ([25,50,100,500] as $opt) {
        echo '<option value="'.$opt.'" '.selected($per_page, $opt, false).'>'.$opt.'</option>';
    }
    echo '</select>';
    
    echo '</form>';
    echo '</div>';

    echo '<table class="widefat striped">';
    echo '<thead><tr>';

    function rm_sort_link($label, $column, $current_order_by, $current_order){

        $is_active = $current_order_by === $column;
        $new_order = ($is_active && $current_order === 'ASC') ? 'DESC' : 'ASC';
    
        $url = add_query_arg([
            'page' => 'rm-representantes',
            'orderby' => $column,
            'order' => $new_order
        ], admin_url('admin.php'));
    
        // Ícones estilo WP
        $icon = '⇅'; // padrão
    
        if ($is_active) {
            $icon = $current_order === 'ASC' ? '↑' : '↓';
        }
    
        return '<a href="'.$url.'" style="display:flex;align-items:center;gap:5px;">
            '.$label.' <span style="font-size:10px;">'.$icon.'</span>
        </a>';
    }
    
    echo '<th>'.rm_sort_link('Nome', 'nome', $order_by, $order).'</th>';
    echo '<th>Telefones</th>';
    echo '<th>'.rm_sort_link('Email', 'email', $order_by, $order).'</th>';
    echo '<th>Cidades</th>';
    echo '<th>Ações</th>';
    
    echo '</tr></thead>';

    foreach ($representantes as $rep) {

        $edit_url = admin_url('admin.php?page=rm-representantes&edit='.$rep->id);
        $delete_url = wp_nonce_url(admin_url('admin.php?page=rm-representantes&delete='.$rep->id),'rm_delete_rep');

        echo '<tr>';
        echo '<td>'.esc_html($rep->nome).'</td>';
        echo '<td>'.esc_html($rep->telefones).'</td>';
        echo '<td>'.esc_html($rep->email).'</td>';
        echo '<td>'.intval($rep->total_cidades).'</td>';
        echo '<td>
        <a href="'.$edit_url.'">Editar</a> | 
        <a href="'.$delete_url.'" onclick="return confirm(\'Tem certeza que deseja excluir este representante?\')">Excluir</a>
        </td>';
=======
    $cidades = $wpdb->get_results("SELECT * FROM $cidades_table ORDER BY nome ASC");

    // QUERY OTIMIZADA
    $representantes = $wpdb->get_results("
        SELECT r.*, GROUP_CONCAT(c.nome) as cidades
        FROM $table r
        LEFT JOIN $rel_table rc ON rc.representante_id = r.id
        LEFT JOIN $cidades_table c ON c.id = rc.cidade_id
        GROUP BY r.id
        ORDER BY r.nome ASC
    ");

    echo '<div class="wrap"><h1>Representantes</h1>';

    echo '<a href="?page=rm-representantes&novo=1" class="button">Novo</a>';

    echo '<div style="display:flex;gap:20px;margin-top:15px;">';

    // FORM
    echo '<div style="width:300px;">';
    echo '<form method="POST">';
    wp_nonce_field('rm_rep_nonce');

    echo '<input type="hidden" name="id" value="' . esc_attr($edit->id ?? '') . '">';

    echo '<input type="text" name="nome" placeholder="Nome" value="' . esc_attr($edit->nome ?? '') . '" required style="width:100%;margin-bottom:10px;">';

    echo '<input type="text" name="telefone" placeholder="Telefone" value="' . esc_attr($edit->telefone ?? '') . '" style="width:100%;margin-bottom:10px;">';

    echo '<input type="email" name="email" placeholder="Email" value="' . esc_attr($edit->email ?? '') . '" style="width:100%;margin-bottom:10px;">';

    echo '<select name="cidades[]" multiple style="width:100%;height:120px;">';

    foreach ($cidades as $cidade) {

        $selected = (!empty($selected_cidades) && in_array($cidade->id, $selected_cidades)) ? 'selected' : '';

        echo '<option value="' . esc_attr($cidade->id) . '" ' . $selected . '>' . esc_html($cidade->nome) . '</option>';
    }

    echo '</select>';

    echo '<button type="submit" name="rm_save_rep" class="button button-primary" style="margin-top:10px;">Salvar</button>';

    echo '</form>';
    echo '</div>';

    // LISTA
    echo '<div style="flex:1;">';

    echo '<table class="widefat">';
    echo '<thead><tr><th>ID</th><th>Nome</th><th>Telefone</th><th>Email</th><th>Cidades</th><th>Ações</th></tr></thead><tbody>';

    foreach ($representantes as $rep) {

        $cidades_lista = $rep->cidades ? explode(',', $rep->cidades) : [];

        $edit_url = admin_url('admin.php?page=rm-representantes&edit=' . $rep->id);

        $delete_url = wp_nonce_url(
            admin_url('admin.php?page=rm-representantes&delete=' . $rep->id),
            'rm_delete_rep'
        );

        echo '<tr>';
        echo '<td>' . $rep->id . '</td>';
        echo '<td>' . esc_html($rep->nome) . '</td>';
        echo '<td>' . esc_html($rep->telefone) . '</td>';
        echo '<td>' . esc_html($rep->email) . '</td>';
        echo '<td>' . esc_html(implode(', ', $cidades_lista)) . '</td>';
        echo '<td>';
        echo '<a href="' . esc_url($edit_url) . '">Editar</a> | ';
        echo '<a href="' . esc_url($delete_url) . '" onclick="return confirm(\'Tem certeza?\')">Excluir</a>';
        echo '</td>';
>>>>>>> d5ae31fde395fecd55b176c5367858ed25209432
        echo '</tr>';
    }

    echo '</tbody></table>';
<<<<<<< HEAD

    echo '<div style="margin-top:15px;display:flex;gap:5px;flex-wrap:wrap;">';

    for ($p = 1; $p <= $total_pages; $p++) {
    
        $url = add_query_arg([
            'page'=>'rm-representantes',
            'paged'=>$p,
            'per_page'=>$per_page,
            's'=>$search,
            'orderby'=>$order_by,
            'order'=>$order
        ], admin_url('admin.php'));
    
        $style = $p == $page ? 'font-weight:bold;background:#0073aa;color:#fff;' : '';
    
        echo '<a href="'.esc_url($url).'" class="button" style="'.$style.'">'.$p.'</a>';
    }
    
    echo '</div>';

    echo '</div></div>';

    echo '
    <script>
    (function(){
    
        // ADD TELEFONE
        document.getElementById("add-telefone")?.addEventListener("click", function(){
            const input = document.createElement("input");
            input.name = "telefones[]";
            input.style.width = "100%";
            input.style.marginBottom = "5px";
            document.getElementById("telefones-wrapper").appendChild(input);
        });
    
        // FILTROS (igual cidades)
        const form = document.getElementById("rm-filtro-form");
        const search = document.getElementById("rm-search");
        const perPage = document.getElementById("rm-per-page");
    
        let timeout = null;
    
        // Busca automática (debounce)
        if(search){
            search.addEventListener("keyup", function(){
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    form.submit();
                }, 250);
            });
        }
    
        // Mudança de quantidade
        if(perPage){
            perPage.addEventListener("change", function(){
                form.submit();
            });
        }
    
    })();
    </script>';
=======
    echo '</div>';

    echo '</div></div>';
}

// Assets (mantido)
add_action('wp_enqueue_scripts', 'rm_enqueue_assets');

function rm_enqueue_assets() {

    wp_enqueue_style('rm-style', RM_URL . 'assets/css/style.css', [], RM_VERSION);
    wp_enqueue_script('rm-script', RM_URL . 'assets/js/script.js', [], RM_VERSION, true);
>>>>>>> d5ae31fde395fecd55b176c5367858ed25209432
}