namespace TCPClient
{
    partial class Form1
    {
        /// <summary>
        /// Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        /// Required method for Designer support - do not modify
        /// the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            this.textMsg = new System.Windows.Forms.TextBox();
            this.textPort = new System.Windows.Forms.TextBox();
            this.label2 = new System.Windows.Forms.Label();
            this.textHost = new System.Windows.Forms.TextBox();
            this.label1 = new System.Windows.Forms.Label();
            this.btnConnect = new System.Windows.Forms.Button();
            this.btnSend = new System.Windows.Forms.Button();
            this.textStatus = new System.Windows.Forms.TextBox();
            this.btnStop = new System.Windows.Forms.Button();
            this.textName = new System.Windows.Forms.TextBox();
            this.UserName = new System.Windows.Forms.Label();
            this.SuspendLayout();
            // 
            // textMsg
            // 
            this.textMsg.Location = new System.Drawing.Point(53, 56);
            this.textMsg.Multiline = true;
            this.textMsg.Name = "textMsg";
            this.textMsg.Size = new System.Drawing.Size(452, 113);
            this.textMsg.TabIndex = 13;
            // 
            // textPort
            // 
            this.textPort.Location = new System.Drawing.Point(185, 28);
            this.textPort.Name = "textPort";
            this.textPort.Size = new System.Drawing.Size(82, 22);
            this.textPort.TabIndex = 11;
            this.textPort.Text = "80";
            // 
            // label2
            // 
            this.label2.AutoSize = true;
            this.label2.Location = new System.Drawing.Point(142, 31);
            this.label2.Name = "label2";
            this.label2.Size = new System.Drawing.Size(38, 17);
            this.label2.TabIndex = 10;
            this.label2.Text = "Port:";
            // 
            // textHost
            // 
            this.textHost.Location = new System.Drawing.Point(53, 28);
            this.textHost.Name = "textHost";
            this.textHost.Size = new System.Drawing.Size(82, 22);
            this.textHost.TabIndex = 9;
            this.textHost.Text = "127.0.0.1";
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Location = new System.Drawing.Point(10, 31);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(41, 17);
            this.label1.TabIndex = 8;
            this.label1.Text = "Host:";
            // 
            // btnConnect
            // 
            this.btnConnect.Location = new System.Drawing.Point(273, 27);
            this.btnConnect.Name = "btnConnect";
            this.btnConnect.Size = new System.Drawing.Size(131, 24);
            this.btnConnect.TabIndex = 7;
            this.btnConnect.Text = "Connect";
            this.btnConnect.UseVisualStyleBackColor = true;
            this.btnConnect.Click += new System.EventHandler(this.btnConnect_Click);
            // 
            // btnSend
            // 
            this.btnSend.Location = new System.Drawing.Point(437, 175);
            this.btnSend.Name = "btnSend";
            this.btnSend.Size = new System.Drawing.Size(68, 24);
            this.btnSend.TabIndex = 12;
            this.btnSend.Text = "Send";
            this.btnSend.UseVisualStyleBackColor = true;
            this.btnSend.Click += new System.EventHandler(this.btnSend_Click);
            // 
            // textStatus
            // 
            this.textStatus.Location = new System.Drawing.Point(53, 205);
            this.textStatus.Multiline = true;
            this.textStatus.Name = "textStatus";
            this.textStatus.Size = new System.Drawing.Size(452, 189);
            this.textStatus.TabIndex = 14;
            // 
            // btnStop
            // 
            this.btnStop.Location = new System.Drawing.Point(410, 27);
            this.btnStop.Name = "btnStop";
            this.btnStop.Size = new System.Drawing.Size(68, 24);
            this.btnStop.TabIndex = 15;
            this.btnStop.Text = "Stop";
            this.btnStop.UseVisualStyleBackColor = true;
            this.btnStop.Click += new System.EventHandler(this.btnStop_Click);
            // 
            // textName
            // 
            this.textName.Location = new System.Drawing.Point(90, 6);
            this.textName.Name = "textName";
            this.textName.Size = new System.Drawing.Size(124, 22);
            this.textName.TabIndex = 17;
            this.textName.Text = "Client";
            // 
            // UserName
            // 
            this.UserName.AutoSize = true;
            this.UserName.Location = new System.Drawing.Point(11, 9);
            this.UserName.Name = "UserName";
            this.UserName.Size = new System.Drawing.Size(79, 17);
            this.UserName.TabIndex = 16;
            this.UserName.Text = "UserName:";
            // 
            // Form1
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(8F, 16F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(530, 406);
            this.Controls.Add(this.textName);
            this.Controls.Add(this.UserName);
            this.Controls.Add(this.btnStop);
            this.Controls.Add(this.textStatus);
            this.Controls.Add(this.textMsg);
            this.Controls.Add(this.btnSend);
            this.Controls.Add(this.textPort);
            this.Controls.Add(this.label2);
            this.Controls.Add(this.textHost);
            this.Controls.Add(this.label1);
            this.Controls.Add(this.btnConnect);
            this.Name = "Form1";
            this.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen;
            this.Text = "Client";
            this.Load += new System.EventHandler(this.Form1_Load);
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.TextBox textMsg;
        private System.Windows.Forms.TextBox textPort;
        private System.Windows.Forms.Label label2;
        private System.Windows.Forms.TextBox textHost;
        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.Button btnConnect;
        private System.Windows.Forms.Button btnSend;
        private System.Windows.Forms.TextBox textStatus;
        private System.Windows.Forms.Button btnStop;
        private System.Windows.Forms.TextBox textName;
        private System.Windows.Forms.Label UserName;
    }
}

