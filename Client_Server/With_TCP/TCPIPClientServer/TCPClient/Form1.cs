using SimpleTCP;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace TCPClient
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
            btnStop.Enabled = false;
        }
        SimpleTcpClient client;
        string serverName;
        string clientName;

        private void Form1_Load(object sender, EventArgs e)
        {
            client = new SimpleTcpClient();
            client.StringEncoder = Encoding.UTF8;
            client.DataReceived += Client_DataReceived;
        }

        private void Client_DataReceived(object sender, SimpleTCP.Message e)
        {
            textStatus.Invoke((MethodInvoker)delegate ()
            {
                if (e.MessageString.Contains("#N#A#M#E#"))
                {
                    serverName = e.MessageString.Split(' ')[1];
                }
                else
                {
                    if (!e.MessageString.Contains("Connection terminated by Server"))
                    {
                        textStatus.Text += serverName;
                    }
                    textStatus.Text += e.MessageString + System.Environment.NewLine;
                    if (e.MessageString.Contains("Connection terminated by Server"))
                    {
                        client.Disconnect();
                        btnConnect.Enabled = true;
                        btnStop.Enabled = false;
                    }
                }
            });
            
        }

        private void btnConnect_Click(object sender, EventArgs e)
        {
            btnConnect.Enabled = false;
            btnStop.Enabled = true;
            clientName = textName.Text;
            textStatus.Text += "Connected" + System.Environment.NewLine;
            client.Connect(textHost.Text, Convert.ToInt32(textPort.Text));
            client.WriteLine("Connected");
            client.WriteLine("#N#A#M#E# " + clientName + ":");
        }

        private void btnSend_Click(object sender, EventArgs e)
        {
            if(textMsg.Text != "")
            {
                client.WriteLine(textMsg.Text);
                textStatus.Text += clientName + ": " + textMsg.Text + System.Environment.NewLine;
                textMsg.Text = "";
            }
        }

        private void btnStop_Click(object sender, EventArgs e)
        {
            client.WriteLine("Connection terminated by Client.");
            client.Disconnect();
            textStatus.Text += "Connection successfully terminated." + System.Environment.NewLine;
            btnConnect.Enabled = true;
            btnStop.Enabled = false;
        }
    }
}
