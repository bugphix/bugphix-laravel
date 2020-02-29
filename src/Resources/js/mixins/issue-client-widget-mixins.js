const issueClientWidgetMixin = {
  data() {
    return {
      clientWidgetsData: [],
    }
  },
  methods: {
    resetWidget(){
      this.clientWidgetsData = [];
    },
    pushWidget(icon, content){
      this.clientWidgetsData.push({
        icon: icon || 'mdi-help',
        content: content || '',
      });
    },
    addUserWidget(){
      if(!this.userDetails) return;

      const {user_unique, user_info} = this.userDetails;

      let content = user_unique;
      if(user_unique !== user_info){
        content += `<br> ${user_info}`;
      }
      this.pushWidget('mdi-account', content);

    },
    addClientWidget(){
      if(!this.clientDetails) return;
      let icon;
      const {client_browser, client_browser_version, client_os} = this.clientDetails;

      if(client_os){
        icon = 'mdi-help';
        if(client_os.toLowerCase().indexOf('win') !== -1){
          icon = 'mdi-windows';
        }
        else if(client_os.toLowerCase().indexOf('mac') !== -1){
          icon = 'mdi-apple';
        }
        else if(client_os.toLowerCase().indexOf('linux') !== -1){
          icon = 'mdi-linux';
        }
        else if(client_os.toLowerCase().indexOf('ubuntu') !== -1){
          icon = 'mdi-ubuntu';
        }
        this.pushWidget(icon, client_os);
      }

      if(client_browser){

        icon = 'mdi-help';

        if(client_browser.toLowerCase().indexOf('chrome') !== -1){
          icon = 'mdi-google-chrome';
        }
        else if(client_browser.toLowerCase().indexOf('explorer') !== -1){
          icon = 'mdi-internet-explorer';
        }
        else if(client_browser.toLowerCase().indexOf('firefox') !== -1){
          icon = 'mdi-firefox';
        }
        else if(client_browser.toLowerCase().indexOf('safari') !== -1){
          icon = 'mdi-apple-safari';
        }
        else if(client_browser.toLowerCase().indexOf('opera') !== -1){
          icon = 'mdi-opera';
        }
        else if(client_browser.toLowerCase().indexOf('edge') !== -1){
          icon = 'mdi-edge';
        }
        const browserContent = `${client_browser} <br> Version: ${client_browser_version}`;
        this.pushWidget(icon, browserContent);
      }

    },
    addServerWidgets(){
      if(!this.serverDetails) return;
      const {server_runtime} = this.serverDetails;
      let icon = 'mdi-help';

      if(server_runtime.indexOf('php')){
        icon = 'mdi-language-php';
      }
      this.pushWidget(icon, server_runtime);
    },
    initWidgets(){
      this.resetWidget();
      this.addUserWidget();
      this.addClientWidget();
      this.addServerWidgets();
    }
  }
};

export default issueClientWidgetMixin;
