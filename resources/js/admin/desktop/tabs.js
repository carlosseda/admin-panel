const tabsItems = document.querySelectorAll('.tab-item');
const tabPanels = document.querySelectorAll(".tab-panel");

tabsItems.forEach(tabItem => { 

    tabItem.addEventListener("click", () => {

        let activeElements = document.querySelectorAll(".tab-active");

        activeElements.forEach(activeElement => {
            activeElement.classList.remove("tab-active");
        });
        
        tabItem.classList.add("tab-active");

        tabPanels.forEach(tabPanel => {

            if(tabPanel.dataset.tab == tabItem.dataset.tab){
                tabPanel.classList.add("tab-active"); 
            }
        });
    });
});

