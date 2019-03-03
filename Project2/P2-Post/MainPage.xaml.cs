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
using Windows.Storage.Pickers;
using Windows.Storage.AccessCache;
using System.Reflection;

// The Blank Page item template is documented at https://go.microsoft.com/fwlink/?LinkId=402352&clcid=0x409

namespace CS350P3JD262
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
        private string Subject, Name, Message;
        private static List<string> errorList;
        private static string errorAppend = " field can not be empty!";
        private static int errorIndex;
        StorageFolder folder = null;
        private async void submitButton_Click(object sender, RoutedEventArgs e)
        {

            Subject = subjectTextBox.Text.ToString();
            Name = nameTextBox.Text.ToString();
            Message = messageTextBox.Text.ToString();

            errorIndex = 0;
            errorList = new List<string>();

            if (string.IsNullOrWhiteSpace(Subject))
            {
                errorHandler(GetName(new { Subject }));
            }
            if (string.IsNullOrWhiteSpace(Name))
            {
                errorHandler(GetName(new { Name }));
            }
            if (string.IsNullOrWhiteSpace(Message))
            {
                errorHandler(GetName(new { Message }));
            }
            else
            {
                string fileText = "Subject: " + subjectTextBox.Text.ToString() + Environment.NewLine +
                                   "Name: " + nameTextBox.Text.ToString() + Environment.NewLine +
                                   "Message: " + messageTextBox.Text.ToString() + Environment.NewLine +
                                   "----------------------------------------------------------------";

                string time = DateTime.Now.ToString("MM-dd-yyyy-hh-mm-ss-fff");


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

                StorageFile messageFile;
                try
                {
                    messageFile = await folder.GetFileAsync(time);
                }
                catch (Exception)
                {
                    messageFile = await folder.CreateFileAsync(time, CreationCollisionOption.ReplaceExisting);
                }

                await FileIO.WriteTextAsync(messageFile, fileText);

               /* try
                {
                  
                    Windows.Storage.StorageFolder storageFolder =
                        Windows.Storage.ApplicationData.Current.LocalFolder;
                    Windows.Storage.StorageFile messageFile =
                        await storageFolder.CreateFileAsync(time,
                            Windows.Storage.CreationCollisionOption.ReplaceExisting);

                    await Windows.Storage.FileIO.WriteTextAsync(messageFile, fileText);
                }
                catch(Exception ex)
                {
                    Show(ex.ToString());
                }*/
            }
            
            Show(prepareMessage());
        }

        static public async void Show(string message)
        {
            var dialog = new MessageDialog(message, "Attention!");
            await dialog.ShowAsync();
        }

        static string GetName<T>(T item) where T : class
        {
            return typeof(T).GetProperties()[0].Name;
        }
        static void errorHandler(string errorName)
        {
            errorList.Add(errorName);
            errorIndex++;
        }
        static string prepareMessage()
        {
            string preparedMessage = "";

            if (errorList.Count > 0)
            {
                preparedMessage += errorList[0];
                for (int i = 1; i < errorList.Count; i++)
                {
                    if (errorList.Count > 2)
                    {
                        if (!(i == errorList.Count - 1))
                            preparedMessage += ", " + errorList[i];
                        else
                            preparedMessage += ",";
                    }
                    if (i == errorList.Count - 1)
                    {
                        preparedMessage += " and " + errorList[i];
                        i++;
                    } 
                }

                preparedMessage += errorAppend;
                
                if (errorList.Count > 1)
                {
                    int addS = preparedMessage.IndexOf("field") + 5;
                    preparedMessage = preparedMessage.Insert(addS, "s");
                }
            }
            else
                preparedMessage = "Success! Your message was submitted.";

            return preparedMessage;
        }
    }
}
