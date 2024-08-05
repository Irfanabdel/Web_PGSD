<x-app-layout title="Edit Nilai">
    <div class="p-4 sm:ml-64">
        <h1>Edit Nilai</h1>

            <form action="{{ route('nilai.update', $nilai->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div>
               
                    <label for="nama_siswa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Siswa</label>
                    <span class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg px-2.5 py-1.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ $nilai->user->name }}</span>
                    
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Mapel</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            
                            <td>
                                <label for="nilai_mapel_1" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white mx-3">Berempati kepada orang lain</label>
                            </td>
                            <td>
                                <select name="nilai_mapel_1" id="nilai_mapel_1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">Pilih Nilai</option>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}" {{ $i == $nilai->nilai_mapel_1 ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </td>
    
                        </tr>
                        <tr>
                            <td>
                                <label for="nilai_mapel_2" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white mx-3">Pemahaman Agama/Kepercayaan</label>
                            </td>
                            <td>
                                <select name="nilai_mapel_2" id="nilai_mapel_2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">Pilih Nilai</option>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}" {{ $i == $nilai->nilai_mapel_2 ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="nilai_mapel_3" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white mx-3">Mengutamakan persamaan dengan orang lain dan menghargai perbedaan</label>
                            </td>
                            <td>
                                <select name="nilai_mapel_3" id="nilai_mapel_3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">Pilih Nilai</option>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}" {{ $i == $nilai->nilai_mapel_3 ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </td>
                        </tr>
                    </tbody>
             
                </table>
                
                <div class="mb-5">
                    <label for="nama_sekolah" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Sekolah</label>
                    <input type="text" name="nama_sekolah" id="nama_sekolah" class="block w-full p-4 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ $nilai->nama_sekolah }}">
                </div>
                <div class="mb-5">
                    <label for="alamat_sekolah" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat Sekolah</label>
                    <input type="text" name="alamat_sekolah" id="alamat_sekolah" class="block w-full p-4 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ $nilai->alamat_sekolah }}">
                </div>
                <div class="mb-5">
                    <label for="projek_1" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Projek 1:</label>
                    <textarea id="projek_1" name="projek_1" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Projek 1.....">{{ $nilai->projek_1 }}</textarea>
                </div>
                <div class="mb-5">
                    <label for="projek_2" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Projek 2:</label>
                    <textarea id="projek_2" name="projek_2" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Projek 1.....">{{ $nilai->projek_2 }}</textarea>
                </div>
                
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Perbaharui</button>
             
            </form>
            
        
        </form>
    </div>
</x-app-layout>
