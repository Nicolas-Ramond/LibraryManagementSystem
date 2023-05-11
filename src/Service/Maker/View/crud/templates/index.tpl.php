{% extends "datatable_layout.html.twig" %}

{% block page_title 'page.title.<?= $route_name ?>.list' | trans({}, 'page') %}

{% trans_default_domain 'datatable' %}

{% block new_record_link '' ~ path('<?= $route_name ?>_new') %}

{% block datable %}
<!--begin: Datatable -->
<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
    <thead>
    <tr>
        <th>Record ID</th>

        <?php foreach ($entity_fields as $field): ?>
        <th>{{ 'datatable.<?= $field['fieldName'] ?>' | trans({}, 'datatable') }}</th>
        <?php endforeach; ?>

        <th>ACTIONS</th>
    </tr>
    </thead>

    <tbody>
        {% for <?= $route_name ?> in <?= $route_name ?>s %}
        <tr>
            <td>{{ <?= $route_name ?>.id }}</td>

            <?php foreach ($entity_fields as $field): ?>
            <td>{{ <?= $helper->getEntityFieldPrintCode($entity_twig_var_singular, $field) ?> }}</td>
            <?php endforeach; ?>

            <td nowrap>
                {% if false %}
                <span class="dropdown">
                                <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                                    <i class="la la-ellipsis-h"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit</a>
                                    <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>
                                    <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>
                                </div>
                            </span>
                {% endif %}

                <a
                        href="{{ path('backend_<?= $route_name ?>_show', {'<?= $entity_identifier ?>': <?= $entity_twig_var_singular ?>.<?= $entity_identifier ?>}) }}"
                        class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                        title="View"
                >
                    <i class="la la-eye"></i>
                </a>

                <a
                        href="{{ path('backend_<?= $route_name ?>_edit', {'<?= $entity_identifier ?>': <?= $entity_twig_var_singular ?>.<?= $entity_identifier ?>}) }}"
                        class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                        title="Edit"
                >
                    <i class="la la-edit"></i>
                </a>

                <form style="display: inline" method="post" action="{{ path('backend_<?= $route_name ?>_delete', {'id': <?= $route_name ?>.id}) }}" onsubmit="return confirm('Are you sure you want to delete this item?');" class="inline-flex">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token('delete' ~ <?= $route_name ?>.id) }}">

                    <button
                            href="{{ path('backend_<?= $route_name ?>_edit', {'id' : <?= $route_name ?>.id}) }}"
                            class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill"
                            title="View"
                    >
                        <i class="la la-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
        {% else %}
        <tr>
            <td colspan="2">{{ 'datatable.no_records_found' | trans({}, 'datatable') }}</td>
        </tr>
        {% endfor %}
    </tbody>
</table>
{% endblock datable %}