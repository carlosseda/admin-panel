import NestedSort from 'nested-sort';
import {renderMenuItems} from './menuItems';

export let renderNestedSortables = () => {
    
    document.addEventListener("renderFormModules",( event =>{
        renderNestedSortables();
    }), {once: true});

    let nestedContainers = document.querySelectorAll('.nested-sort-wrap');

    nestedContainers.forEach(nestedContainer => {

        if(nestedContainer){
    
            let url = nestedContainer.dataset.route;
            let orderUrl = nestedContainer.dataset.order;
            let nestedContainerId = '#' + nestedContainer.id;

            let sendIndexRequest = () => {
    
                try {
                    axios.get(url).then(response => {
                        
                        new NestedSort({
    
                            data: response.data.items,
                            propertyMap: {
                                id: 'id',
                                parent: 'parent_id',
                                text: 'name',
                            },
                            actions: {
                                onDrop(data) { 
                                    storeOrder(orderUrl,data);
                                }
                            },
                
                            el: nestedContainerId, 
                            listClassNames: ['nested-sort'] 
                        });

                        setItemActions();
                        renderMenuItems();
                    });
                    
                } catch (error) {

                }
            };

            sendIndexRequest();

        }
    });
}

function storeOrder(url, data){

    let sendOrderPostRequest = async () => {
    
        try {
            await axios.post(url, data).then(response => {

            });
            
        } catch (error) {

            if(error.response.status == '500'){
            
            }
        }
    };

    sendOrderPostRequest();
}

function setItemActions(){

    let itemActions = document.getElementById('item-actions');
    let nestedSorts = document.querySelectorAll('.nested-sort li');

    nestedSorts.forEach( nestedSort => {

        if(!nestedSort.querySelector('#item-actions')){

            let itemActionsCloned = itemActions.cloneNode(true);
            let itemEdit = itemActionsCloned.querySelector('.item-edit');
            let itemDelete = itemActionsCloned.querySelector('.item-delete')

            itemActionsCloned.classList.remove('clone');
            itemEdit.dataset.id = nestedSort.dataset.id;
            itemDelete.dataset.id = nestedSort.dataset.id;

            nestedSort.insertAdjacentElement('afterbegin', itemActionsCloned);
        }
    });
}