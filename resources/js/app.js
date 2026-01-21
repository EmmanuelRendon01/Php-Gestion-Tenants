import './bootstrap';


window.bootstrap = window.bootstrap || {};

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
            
            const modalEl = document.getElementById('viewTenantModal');
            const modal = new window.bootstrap.Modal(modalEl);
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
            
            const modalEl = document.getElementById('editTenantModal');
            const modal = new window.bootstrap.Modal(modalEl);
            modal.show();
        })
        .catch(error => console.error('Error:', error));
}

window.deleteTenant = function(tenantId) {
    document.getElementById('delete-tenant-id').textContent = tenantId;
    document.getElementById('deleteTenantForm').action = `/tenants/${tenantId}`;
    
    const modalEl = document.getElementById('deleteTenantModal');
    const modal = new window.bootstrap.Modal(modalEl);
    modal.show();
}

// Funciones para manejo de productos
window.viewProduct = function(productId) {
    console.log('viewProduct called with ID:', productId);
    fetch(`/admin/products/${productId}`)
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            console.log('Product data received:', data);
            document.getElementById('view-product-name').textContent = data.name;
            document.getElementById('view-product-sku').textContent = data.sku;
            document.getElementById('view-product-description').textContent = data.description;
            document.getElementById('view-product-price').textContent = data.price;
            document.getElementById('view-product-stock').textContent = data.stock + ' unidades';
            document.getElementById('view-product-category').textContent = data.category;
            document.getElementById('view-product-active').textContent = data.active;
            document.getElementById('view-product-created').textContent = data.created_at;
            document.getElementById('view-product-updated').textContent = data.updated_at;
            
            // Mostrar/ocultar imagen
            const imgElement = document.getElementById('view-product-image');
            const noImageElement = document.getElementById('view-product-no-image');
            if (data.image) {
                imgElement.src = data.image;
                imgElement.style.display = 'block';
                noImageElement.style.display = 'none';
            } else {
                imgElement.style.display = 'none';
                noImageElement.style.display = 'block';
            }
            
            const modalEl = document.getElementById('viewProductModal');
            const modal = new window.bootstrap.Modal(modalEl);
            modal.show();
        })
        .catch(error => console.error('Error:', error));
}

window.editProduct = function(productId) {
    console.log('editProduct called with ID:', productId);
    fetch(`/admin/products/${productId}/edit`)
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            console.log('Product edit data received:', data);
            document.getElementById('edit-name').value = data.name;
            document.getElementById('edit-sku').value = data.sku;
            document.getElementById('edit-description').value = data.description || '';
            document.getElementById('edit-price').value = data.price;
            document.getElementById('edit-stock').value = data.stock;
            document.getElementById('edit-category').value = data.category || '';
            document.getElementById('edit-active').checked = data.active;
            document.getElementById('editProductForm').action = `/admin/products/${productId}`;
            
            // Mostrar preview de imagen actual
            const imgPreview = document.getElementById('edit-product-image-preview');
            if (data.image) {
                imgPreview.src = data.image;
                imgPreview.style.display = 'block';
            } else {
                imgPreview.style.display = 'none';
            }
            
            const modalEl = document.getElementById('editProductModal');
            const modal = new window.bootstrap.Modal(modalEl);
            modal.show();
        })
        .catch(error => console.error('Error:', error));
}

window.deleteProduct = function(productId) {
    console.log('deleteProduct called with ID:', productId);
    // Obtener el nombre del producto desde la tabla
    const row = event.target.closest('tr');
    const productName = row.querySelector('td:nth-child(3)').textContent;
    
    document.getElementById('delete-product-name').textContent = productName;
    document.getElementById('deleteProductForm').action = `/admin/products/${productId}`;
    
    const modalEl = document.getElementById('deleteProductModal');
    const modal = new window.bootstrap.Modal(modalEl);
    modal.show();
}
