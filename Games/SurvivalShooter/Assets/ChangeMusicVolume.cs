using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;


public class ChangeMusicVolume : MonoBehaviour {

	public Slider MasterVolume;
	public Slider MusicVolume;
	public Slider SfxVolume;
	public AudioSource MenuMusic;
	public AudioSource LoadSound;
	public AudioSource CloseSound;
	public AudioSource QuitSound;
	public AudioSource ButtonHighlightSound;


	// Update is called once per frame
	void Update () {
        float master = MasterVolume.value;
		//MenuMusic.volume = MasterVolume.value;
		//CloseSound.volume = MasterVolume.value;
		//LoadSound.volume = MasterVolume.value;
		//QuitSound.volume = MasterVolume.value;
		//ButtonHighlightSound.volume = MasterVolume.value;


		MenuMusic.volume = MusicVolume.value * master;


		CloseSound.volume = SfxVolume.value * master;
		LoadSound.volume = SfxVolume.value * master;
		QuitSound.volume = SfxVolume.value * master;
		ButtonHighlightSound.volume = SfxVolume.value * master;


	}
}
