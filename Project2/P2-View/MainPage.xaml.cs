using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Runtime.InteropServices.WindowsRuntime;
using Windows.Foundation;
using Windows.Foundation.Collections;
using Windows.UI.Xaml;
using Windows.UI.Xaml.Controls;
using Windows.UI.Xaml.Controls.Primitives;
using Windows.UI.Xaml.Data;
using Windows.UI.Xaml.Input;
using Windows.UI.Xaml.Media;
using Windows.UI.Xaml.Navigation;
using Windows.UI.Popups;
using Windows.Storage;
using Windows.Storage.AccessCache;
using Windows.Storage.Pickers;
//using Windows.Storage.AccessCache;

// The Blank Page item template is documented at https://go.microsoft.com/fwlink/?LinkId=402352&clcid=0x409

namespace CS350P35JD262
{
    /// <summary>
    /// An empty page that can be used on its own or navigated to within a Frame.
    /// </summary>
    public sealed partial class MainPage : Page
    {
        public MainPage()
        {
            this.InitializeComponent();
            
        }

        private string messageFile = "";
        StorageFolder folder = null;
        

        static public async void Show(string message)
        {
            var dialog = new MessageDialog(message, "Attention!");
            await dialog.ShowAsync();
        }

        private async void displayMessagesButton_Click(object sender, RoutedEventArgs e)
        {
          
            if (folder == null)
            {
                FolderPicker folderPicker = new FolderPicker();
                folderPicker.SuggestedStartLocation = PickerLocationId.Desktop;
                folderPicker.FileTypeFilter.Add("*");  // must have at least 1 filter, otherwise get exception
                folder = await folderPicker.PickSingleFolderAsync();
                if (folder != null)
                {
                    // Application now has read/write access to all contents in the picked folder (including other sub-folder contents)
                    StorageApplicationPermissions.FutureAccessList.AddOrReplace("PickedFolderToken", folder);
                    //debugCol1.Text = debugCol1.Text + "\nPicked folder: " + folder.Name;
                }
                else
                {
                    MessageDialog msg = new MessageDialog("Error opening folder");
                    msg.Commands.Add(new UICommand("OK"));
                    await msg.ShowAsync();
                    return;
                }
            }

            IReadOnlyList<StorageFile> fileList;
            StorageFile inputFile;
            try
            {
                fileList = await folder.GetFilesAsync();
                foreach (StorageFile file in fileList) 
                {
                    inputFile = file;
                    messageListBox.Text += await FileIO.ReadTextAsync(inputFile);
                }
            }
            catch (Exception)
            {
                MessageDialog msg = new MessageDialog("There is no order file");
                msg.Commands.Add(new UICommand("OK"));
                await msg.ShowAsync();
                return;
            }
        }

        

        private void messageListBox_TextChanged(object sender, TextChangedEventArgs e)
        {
            var grid = (Grid)VisualTreeHelper.GetChild(messageListBox, 0);
            for (var i = 0; i <= VisualTreeHelper.GetChildrenCount(grid) - 1; i++)
            {
                object obj = VisualTreeHelper.GetChild(grid, i);
                if (!(obj is ScrollViewer)) continue;
                ((ScrollViewer)obj).ChangeView(0.0f, ((ScrollViewer)obj).ExtentHeight, 1.0f);
                break;
            }
        }
    }
}
