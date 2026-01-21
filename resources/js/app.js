import './bootstrap';

// Funciones para manejo de tenants
window.viewTenant = function(tenantId) {
    fetch(`/tenants/${tenantId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('view-tenant-id').textContent = data.id;
            document.getElementById('view-tenant-email').textContent = data.email;
            document.getElementById('view-tenant-domain').textContent = data.domain;
            document.getElementById('view-tenant-created').textContent = data.created_at;
            document.getElementById('view-tenant-updated').textContent = data.updated_at;
            
            const modal = new bootstrap.Modal(document.getElementById('viewTenantModal'));
            modal.show();
        })
        .catch(error => console.error('Error:', error));
}

window.editTenant = function(tenantId) {
    fetch(`/tenants/${tenantId}/edit`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit-tenant-id').value = data.id;
            document.getElementById('edit-email').value = data.email;
            document.getElementById('edit-domain').value = data.domain;
            document.getElementById('editTenantForm').action = `/tenants/${tenantId}`;
            
            const modal = new bootstrap.Modal(document.getElementById('editTenantModal'));
            modal.show();
        })
        .catch(error => console.error('Error:', error));
}

window.deleteTenant = function(tenantId) {
    document.getElementById('delete-tenant-id').textContent = tenantId;
    document.getElementById('deleteTenantForm').action = `/tenants/${tenantId}`;
    
    const modal = new bootstrap.Modal(document.getElementById('deleteTenantModal'));
    modal.show();
}
