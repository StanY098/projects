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

namespace TCPIPClientServer
{
    public partial class Server : Form
    {
        public Server()
        {
            InitializeComponent();
            btnStop.Enabled = false;
        }

        private void label1_Click(object sender, EventArgs e)
        {

        }
        SimpleTcpServer server;
        string serverName;
        string clientName;
        private void Server_Load(object sender, EventArgs e)
        {
            server = new SimpleTcpServer();
            server.Delimiter = 0x13;
            server.StringEncoder = Encoding.UTF8;
            server.DataReceived += Server_DataReceived;
        }

        private void Server_DataReceived(object sender, SimpleTCP.Message e)
        {
            textStatus.Invoke((MethodInvoker)delegate ()
            {
                if (e.MessageString.Contains("#N#A#M#E#"))
                {
                    clientName = e.MessageString.Split(' ')[1];
                    server.BroadcastLine("#N#A#M#E# " + serverName + ":");
                }
                else
                {
                    if (!e.MessageString.Contains("Connected") && !e.MessageString.Contains("Connection terminated by Client"))
                    {
                        textStatus.Text += clientName;
                    }
                    textStatus.Text += e.MessageString + System.Environment.NewLine;
                    if (e.MessageString.Contains("Connection terminated by Client"))
                    {
                        textStatus.Text += "Server starting..." + System.Environment.NewLine;
                    }
                }
                if (e.MessageString.Contains("Connected"))
                {
                    textStatus.Text += "Connected" + System.Environment.NewLine;
                }
            });
        }

        private void btnStart_Click(object sender, EventArgs e)
        {
            if (!server.IsStarted)
            {
                btnStart.Enabled = false;
                btnStop.Enabled = true;
                serverName = textName.Text;
                textStatus.Text += "Server starting..." + System.Environment.NewLine;
                System.Net.IPAddress ip = System.Net.IPAddress.Parse(textHost.Text);
                server.Start(ip, Convert.ToInt32(textPort.Text));
            }
        }



        private void btnStop_Click(object sender, EventArgs e)
        {
            if (server.IsStarted)
            {
                server.BroadcastLine("Connection terminated by Server");
                server.Stop();
                textStatus.Text += "Connection successfully terminated." + System.Environment.NewLine;
                btnStart.Enabled = true;
                btnStop.Enabled = false;
            }
        }

        private void btnSend_Click(object sender, EventArgs e)
        {
            if(textMsg.Text != "")
            {
                server.BroadcastLine(textMsg.Text);
                textStatus.Text += serverName + ": " + textMsg.Text + System.Environment.NewLine;
                textMsg.Text = "";
            }
        }
    }
}
